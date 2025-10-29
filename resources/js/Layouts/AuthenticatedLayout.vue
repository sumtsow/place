<script setup>
import { ref } from 'vue';
import Footer from '@/Components/Footer.vue';
import { Link } from '@inertiajs/vue3';
</script>

<template>
	<nav class="navbar navbar-expand-lg bg-body-tertiary">
		<div class="container-fluid justify-content-end">
			<div class="nav">
				<Link :href="route('home')" class="navbar-brand">
					<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
					  <span class="navbar-toggler-icon"></span>
					</button>
				</Link>
				<div class="collapse navbar-collapse" id="navbarNavDropdown">
					<ul class="navbar-nav">
						<li class="nav-item">
							<Link class="nav-link active" aria-current="page" :href="route('home')">{{ $page.props.lang.navbar.home }}</Link>
						</li>
						<li class="nav-item">
							<Link class="nav-link" :href="route('dashboard')" :active="route().current('dashboard')">{{ $page.props.lang.navbar.dashboard }}</Link>
						</li>
						<li class="nav-item dropdown">
							<Link class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
							{{ $page.props.auth.user.firstname }} {{ $page.props.auth.user.lastname }}
							</Link>
							<ul class="dropdown-menu">
								<li>
									<Link class="dropdown-item" :href="route('profile.edit')">{ $page.props.lang.navbar.profile }}</Link>
								</li>
								<li>
									<Link class="dropdown-item" :href="route('logout')" method="post">{{ $page.props.lang.navbar.logout }}</Link>
								</li>
							</ul>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</nav>
</template>
