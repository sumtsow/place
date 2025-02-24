<script setup>
import { Link } from '@inertiajs/vue3';
</script>

<template>
	<nav class="navbar navbar-expand-lg">
		<div class="container-fluid justify-content-end">
			<div v-if="$page.props.auth.user" class="navbar-nav">
				<Link :href="route('home')" class="navbar-brand">
					Home
				</Link>
				<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
				  <span class="navbar-toggler-icon"></span>
				</button>
				<div class="collapse navbar-collapse" id="navbarNavDropdown">
					<ul class="navbar-nav">
						<li class="nav-item">
							<Link class="nav-link" :href="route('dashboard')" :active="route().current('dashboard')">Dashboard</Link>
						</li>
						<li class="nav-item dropdown">
							<Link class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
							{{ $page.props.auth.user.firstname }} {{ $page.props.auth.user.lastname }}
							</Link>
							<ul class="dropdown-menu">
								<li>
									<Link class="dropdown-item" :href="route('profile.edit')">Profile</Link>
								</li>
								<li>
									<Link class="dropdown-item" :href="route('logout')" method="post">Log Out</Link>
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
					>Log in
					</Link>
				</div>
				<div class="nav-item">
					<Link
						:href="route('register')"
						class="nav-link"
					>Register
					</Link>
				</div>
			</div>
		</div>
	</nav>
</template>
