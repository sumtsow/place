<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    auth: {
        type: Object,
    },
});

</script>

<template>
	<nav v-if="auth.canLogin" class="navbar navbar-expand-lg bg-body-tertiary mb-3">
		<div class="container-fluid justify-content-end">
			<div class="navbar-nav">
				<div v-if="$page.props.auth.user" class="nav-item">
					<Link
						:href="route('dashboard')"
						class="nav-link"
					>Dashboard
					</Link>
				</div>

				<template v-else>
					<div class="nav-item">
						<Link
							:href="route('login')"
							class="nav-link"
						>Log in
						</Link>
					</div>
					<div class="nav-item">
						<Link
							v-if="auth.canRegister"
							:href="route('register')"
							class="nav-link"
						>Register
						</Link>
					</div>
				</template>
			</div>
		</div>
	</nav>
</template>
