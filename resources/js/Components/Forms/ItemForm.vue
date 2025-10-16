<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SelectList from '@/Components/SelectList.vue';
import TextArea from '@/Components/TextArea.vue';
import TextInput from '@/Components/TextInput.vue';
import { watch } from 'vue';
import { Link, useForm, usePage } from '@inertiajs/vue3';

const props = usePage().props;
const modal = props.modal;
props.item.token = props.csrf_token;
props.item.is_enabled = !!props.item.is_enabled;

let newCategory;

const form = useForm(props.item);

defineProps({
	item: {
        type: Object,
	},
});

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
		if (props.item && props.item.categories) {
			form.categories = props.item.categories;
			props.item.categories.forEach( ( cat ) => {
				cat.pivot.is_main = !!cat.pivot.is_main;
			});
		} else {
			form.categories = [];
		}
});

let addCategory = () => {
	if ( !newCategory || collectionHasModel( props.item.categories, newCategory ) ) return;
	let cat = findModelById( props.categories, newCategory );
	cat.pivot = { category_id: newCategory, item_id: props.item.id, is_main: 0 };
	props.item.categories.push( cat );
};

let removeCategory = (e) => {
	let categoryId = e.target.dataset.id;
	let res = confirm('Ви дійсно хочете видалити категорію з id=' + categoryId + '?') || event.stopImmediatePropagation();
	if (res) {
		let index = props.item.categories.findIndex((cat) => {
			return cat.id === categoryId;
		});
		props.item.categories.splice( index, 1);
	}
	return false;
};

let selectCategory = ( e ) => {
	let hasChildren = findModelById( props.categories, e.target.dataset.id ).hasChildren;
	if ( hasChildren ) {
		form.errors.category_id = 'This Category coudn`t have items!';
	} else {
		form.clearErrors();
	}
	return !hasChildren;
};

let saveItem = () => {
	form.transform((data) => ({
		...data,
		categories: props.item.categories,
	}));
	return !!form.id ? form.put( route('item.update', [form.id])) : form.put(route('item.store'));
};

let toggleSwitch = ( catId ) => {
	props.item.categories.forEach( ( cat ) => {
		cat.pivot.is_main = ( catId === cat.pivot.category_id );
	});
	return catId;
};

</script>

<template>
	<div v-if="item" :class="{ modal: modal }" tabindex="-1" id="itemFormModal"  data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="modalLabel" aria-hidden="true">
		<form name="itemForm" id="item-form" class="p-3 needs-validation" @submit.prevent="saveItem">
			<div :class="{'modal-dialog modal-xl': modal}">
				<div :class="{'modal-content': modal}">
					<div :class="{'modal-header': modal}">
						<div :class="{'modal-title h5': modal, 'h1 text-center': !modal}" id="modalLabel">{{ form && form.id > 0 ? 'Edit item ' + form.id : 'Add item' }}</div>
						<button v-if="modal" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрити" @click="form.clearErrors"></button>
					</div>
					<div :class="{'modal-body': modal}">
						<div class="input-group mb-3 row text-md-left justify-content-start has-validation">
							<div class="col-3"></div>
							<div class="col">
								<div class="form-check form-switch">
									<input id="is_enabled" name="is_enabled" type="checkbox" class="form-check-input" v-model="form.is_enabled"/>
									<label class="form-check-label" for="visible">Enabled</label>
								</div>
							</div>
						</div>

						<div class="input-group row mb-3">
							<InputLabel for="name" value="Name" class="col-3 text-end" />
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
							<InputLabel for="like" value="Likes" class="col-3 text-end" />
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
							<InputLabel for="unit_id" value="Unit Id" class="col-3 text-end" />
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
							<div class="col-3 text-end">Categories</div>
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
							<InputLabel for="description" value="Description" class="col-3 text-end" />
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
							<InputLabel for="images" value="Images" class="col-3 text-end" />
							<TextArea
								id="images"
								class="col"
								v-model="form.images"
								autofocus
								autocomplete="images"
							/>
							<InputError class="mt-2" :message="form.errors.images" />
						</div>
					</div>
					<div class="row justify-content-end">
						<div class="col-2 m-4">
						<PrimaryButton :disabled="form.processing">Save</PrimaryButton>
							<p v-if="form.recentlySuccessful" class="text-success">
								Saved
							</p>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
</template>
