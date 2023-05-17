<template>
    <div>
        <div class="page-titles">
            <h3 class="text-themecolor">{{trans('inventory.inventory')}}</h3>
        </div>
        <div class="container-fluid container-body">
            <div class="row">
                <div class="col-12 col-sm-3">
                	<div class="card">
                        <div class="card-body">
                            <h4 class="card-title">{{trans('library.book')}}</h4>
                            <h6 class="card-subtitle mb-2 text-muted">Card subtitle</h6>
                            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                            <router-link to="/library/book" class="btn btn-info btn-sm">{{trans('general.go_to_link', {link: trans('library.book')})}}</router-link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
	export default {

	}
</script>