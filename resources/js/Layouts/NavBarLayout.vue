<script setup>
import { Link, usePage } from '@inertiajs/vue3';

const props = usePage().props;
const locale = props.locale;
const { lang } = usePage().props;

</script>

<template>
	<nav class="navbar navbar-expand-lg">
		<div class="container-fluid row justify-content-end">
			<div class="col">
				<ul class="nav justify-content-start">
					<li class="nav-item d-inline" v-for="ln in props.locales">
						<Link class="nav-link" :class="{ disabled: ln == locale }" aria-current="page" :href="route('switch.locale', [ln] )">{{ ln.toUpperCase() }}</Link>
					</li>
				</ul>
			</div>
			<div class="col">
				<div v-if="$page.props.auth.user" class="navbar-nav">
					<Link :href="route('home')" class="navbar-brand">
						{{ $page.props.lang.navbar.home }}
					</Link>
					<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
					  <span class="navbar-toggler-icon"></span>
					</button>
					<div class="collapse navbar-collapse" id="navbarNavDropdown">
						<ul class="navbar-nav">
							<li v-if="$page.props.auth.isAdmin" class="nav-item">
								<Link class="nav-link" :href="route('dashboard')" :active="route().current('dashboard')">{{ $page.props.lang.navbar.dashboard }}</Link>
							</li>
							<li class="nav-item dropdown">
								<Link class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
								{{ $page.props.auth.user.firstname }} {{ $page.props.auth.user.lastname }}
								</Link>
								<ul class="dropdown-menu">
									<li>
										<Link class="dropdown-item" :href="route('profile.edit')">{{ $page.props.lang.auth.profile }}</Link>
									</li>
									<li>
										<Link class="dropdown-item" :href="route('logout')" method="post">{{ $page.props.lang.auth.logout }}</Link>
									</li>
								</ul>
							</li>
						</ul>
					</div>
				</div>

				<div v-else class="navbar-nav">
					<div class="nav-item">
						<Link
							:href="route('login')"
							class="nav-link"
						>{{ $page.props.lang.auth.login }}
						</Link>
					</div>
					<div class="nav-item">
						<Link
							:href="route('register')"
							class="nav-link"
						>{{ $page.props.lang.auth.register }}
						</Link>
					</div>
				</div>
			</div>
		</div>
	</nav>
</template>
