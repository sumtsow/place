<template>
	<footer class="fixed-bottom bg-white p-3 row">
		<div class="col">&copy; {{ new Date().getFullYear() }} All rights reserved</div>
		<div class="col text-end">
			<div @click="$emit('scrollToTop')" class="btn btn-outline-secondary btn-sm mx-3">&nbsp;&uArr;&nbsp;</div>
		</div>
	</footer>
</template>
