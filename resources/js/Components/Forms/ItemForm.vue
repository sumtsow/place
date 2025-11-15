<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import SelectList from '@/Components/SelectList.vue';
import TextArea from '@/Components/TextArea.vue';
import TextInput from '@/Components/TextInput.vue';
import { ref, watch } from 'vue';
import { Link, useForm, usePage, router } from '@inertiajs/vue3';

const props = usePage().props;
props.item.token = props.csrf_token;
const modal = props.modal;

let newCategory, newImage;

defineProps({
	item: {
        type: Object,
	},
	emptyItem: {
        type: Object,
	},
	category_id: {
		type: Number,
	},
	image_max: {
		type: Number,
	},
});

const form = useForm(props.item);
const imageForm = useForm({
	image: null,
	item_id: null,
})

watch(
	() => props.item,
	() => {
		form.id = props.item ? props.item.id : 0;
		form.name = props.item ? props.item.name : '';
		form.like = props.item ? props.item.like : 0;
		form.is_enabled = props.item ? props.item.is_enabled : false;
		form.unit_id = props.item ? props.item.unit_id : 0;
		form.description = props.item ? props.item.description : '';
		form.images = props.item ? props.item.images : '';
		form.token = props.csrf_token;
		form.categories = (props.item && props.item.categories) ? props.item.categories : [];
});

const addCategory = () => {
	if ( !newCategory || collectionHasModel( props.item.categories, newCategory ) ) return;
	let cat = findModelById( props.categories, newCategory );
	cat.pivot = { category_id: newCategory, item_id: props.item.id, is_main: 0 };
	props.item.categories.push( cat );
};

const addImage = () => {
	imageForm.image = newImage;
	imageForm.item_id = props.item.id;
	imageForm.post( route( 'item.image-store' ), {
		onSuccess: () => {
			let images = JSON.parse( props.item.images );
			let ext = imageForm.image.type === 'image/png' ? '.png' : '.jpg';
			let index = images ? images.length + 1 : 0;
			index = '' + index;
			index = index.padStart( props.image_max, '0' );
			let filename = 'item-' + imageForm.item_id + '-image-' + index + ext;
			images.push( filename );
			props.item.images = JSON.stringify( images );
			form.images = props.item.images;
		},
	});
	return false;
};

const closeForm = () => {
	resetForm();
};

const deleteImage = (e) => {
	let res = confirm(props.lang.admin.sure_want_delete + props.lang.admin.image + '?');
	if( res ) {
		let filename = e.target.dataset.filename;
		useForm( { filename: filename, category_id: props.category_id } ).delete( route('item.image-delete'), {
			onSuccess: () => {
				let images = JSON.parse( props.item.images );
				let index = images.findIndex( ( image ) => {
					return image === filename;
				});
				images.splice( index, 1);
				props.item.images = JSON.stringify( images );
				form.images = props.item.images;
			},
		});
	}
};

const resetForm = () => {
	props.item = JSON.parse( JSON.stringify( props.emptyItem ) );
	form.clearErrors();
};

const removeCategory = (e) => {
	let categoryId = e.target.dataset.id;
	let res = confirm(props.lang.admin.sure_want_delete + props.lang.admin.category_ + 'id=' + categoryId + '?') || event.stopImmediatePropagation();
	if (res) {
		let index = props.item.categories.findIndex((cat) => {
			return cat.id === categoryId;
		});
		props.item.categories.splice( index, 1);
	}
	return false;
};

const saveItem = () => {
	form.transform((data) => ({
		...data,
		categories: props.item.categories,
	}));
	return !!form.id ? form.put( route('item.update', [form.id])) : form.put(route('item.store'));
};

const selectCategory = ( e ) => {
	let hasChildren = findModelById( props.categories, e.target.dataset.id ).hasChildren;
	if ( hasChildren ) {
		form.errors.category_id = props.lang.admin.have_not_items;
	} else {
		form.clearErrors();
	}
	return !hasChildren;
};

const selectImage = (e) => {
	newImage = e.target.files[0];
};

const toggleSwitch = ( catId ) => {
	props.item.categories.forEach( ( cat ) => {
		cat.pivot.is_main = ( catId === cat.pivot.category_id );
	});
	return catId;
};
</script>

<template>
	<div v-if="props.item" :class="{ modal: modal }" tabindex="-1" id="itemFormModal"  data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="modalLabel" aria-hidden="true">
		<form name="itemForm" id="item-form" class="p-3 needs-validation" @submit.prevent="saveItem">
			<div :class="{'modal-dialog modal-xl': modal}">
				<div :class="{'modal-content': modal}">
					<div :class="{'modal-header': modal}">
						<div :class="{'modal-title h5': modal, 'h1 text-center': !modal}" id="modalLabel">{{ form && form.id > 0 ? $page.props.lang.admin.edit + $page.props.lang.admin.item.toLowerCase() + form.id : $page.props.lang.admin.add + $page.props.lang.admin.item.toLowerCase() }}</div>
						<button v-if="modal" type="button" class="btn-close" data-bs-dismiss="modal" :aria-label="$page.props.lang.admin.close" @click="closeForm"></button>
					</div>
					<div :class="{'modal-body': modal}">
						<div class="input-group mb-3 row text-md-left justify-content-start has-validation">
							<div class="col-3"></div>
							<div class="col">
								<div class="form-check form-switch">
									<input id="is_enabled" name="is_enabled" type="checkbox" class="form-check-input" v-model="form.is_enabled"/>
									<label class="form-check-label" for="visible">{{ $page.props.lang.admin.enabled }}</label>
								</div>
							</div>
						</div>

						<div class="input-group row mb-3">
							<InputLabel for="name" :value="$page.props.lang.admin.name" class="col-3 text-end" />
							<TextInput
								id="name"
								type="text"
								class="col"
								v-model="form.name"
								required
								autofocus
								autocomplete="name"
							/>
							<InputError class="mt-2" :message="form.errors.name" />
						</div>

						<div class="input-group row mb-3">
							<InputLabel for="like" :value="$page.props.lang.admin.likes" class="col-3 text-end" />
							<TextInput
								id="like"
								type="number"
								class="col"
								v-model="form.like"
								required
								autofocus
								autocomplete="like"
							/>
							<InputError class="mt-2" :message="form.errors.like" />
						</div>

						<div class="input-group row mb-3">
							<InputLabel for="unit_id" :value="$page.props.lang.admin.measuring_unit" class="col-3 text-end" />
							<SelectList
								:options="props.units"
								id="unit_id"
								class="col"
								v-model="form.unit_id"
								autofocus
								autocomplete="unit_id"
							/>
							<InputError class="mt-2" :message="form.errors.unit_id" />
						</div>

						<div class="input-group row mb-3">
							<div class="col-3 text-end">{{ $page.props.lang.admin.categories }}</div>
							<div class="col px-0">
								<ul class="list-group list-group-flush">
									<li v-for="cat, key in props.item.categories" class="list-group-item px-0 position-relative">
										<SelectList
											:options="props.categories"
											id="category_id"
											class="col d-inline-block w-75"
											v-model="cat.id"
											:data-id="cat.id"
											:data-key="key"
											autofocus
											autocomplete="category_id"
											@change.prevent="selectCategory"
										/>
										<div class="form-check form-switch d-inline-block align-middle mx-2">
										<input :id="'is_main_' + cat.id" :name="'is_main_' + cat.id" type="checkbox" class="form-check-input" @change="toggleSwitch(cat.pivot.category_id)" v-model="cat.pivot.is_main" />
										</div>
										<button v-if="props.item.categories.length > 1" @click.prevent="removeCategory" class="btn-close d-inline float-end mt-2" :data-id="cat.id"></button>
									</li>
									<li class="list-group-item px-0">
										<SelectList
											:options="props.categories"
											id="new_category_id"
											type="number"
											class="col d-inline-block w-75"
											v-model="newCategory"
											:data-key="key"
											autofocus
											autocomplete="category_id"
										/>
										<PrimaryButton @click.prevent.stop="addCategory" class="d-inline-block float-end"><span class="fs-3 lh-1 py-0">+</span></PrimaryButton>
									</li>
								</ul>
							</div>
							<InputError class="ms-3 mt-2" :message="form.errors.category_id" />
						</div>

						<div class="input-group row mb-3">
							<InputLabel for="description" :value="$page.props.lang.admin.description" class="col-3 text-end" />
							<TextArea
								id="description"
								class="col"
								v-model="form.description"
								autofocus
								autocomplete="description"
							/>
							<InputError class="mt-2" :message="form.errors.description" />
						</div>

						<div class="input-group row mb-3">
							<div v-if="form.images" class="col">
								<div class="d-inline-block position-relative border border-secondary mx-2 p-2 pe-3" v-for="image in JSON.parse( form.images )">
									<img :src="'/storage/img/' + image" :alt="image" class="mx-2" style="max-width: 100px; max-height: 100px;"/>
									<button type="button" class="btn-close position-absolute top-0 end-0" :title="$page.props.lang.admin.delete" @click.prevent="deleteImage" :data-filename="image"></button>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col">
								<div class="input-group mb-3">
									<input id="newImageInput" @change="selectImage" name="image" type="file" class="form-control h-100" accept="image/png, image/jpeg"/>
									<InputLabel for="newImageInput" :value="$page.props.lang.admin.add" class="input-group-text" @click.prevent.stop="addImage" role="button"/>
								</div>
								<div class="alert alert-secondary" role="alert">{{ $page.props.lang.admin.images }}: {{ form.images }}</div>
							</div>
						</div>

						<div class="row justify-content-end">
							<div class="col text-end pe-4">
							<SecondaryButton v-if="modal" class="me-3" :disabled="form.processing" data-bs-dismiss="modal" @click="closeForm">{{ $page.props.lang.customer.cancel }}</SecondaryButton>
							<PrimaryButton :disabled="form.processing">{{ $page.props.lang.customer.save }}</PrimaryButton>
								<p v-if="form.recentlySuccessful" class="text-success">
									{{ $page.props.lang.customer.saved }}
								</p>
							</div>
						</div>

					</div>
				</div>
			</div>
		</form>
	</div>
</template>
