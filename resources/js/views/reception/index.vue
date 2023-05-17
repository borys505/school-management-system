<template>
    <div>
        <div class="page-titles">
            <h3 class="text-themecolor">{{trans('reception.reception')}}</h3>
        </div>
        <div class="container-fluid container-body">
            <div class="row">
                <div class="col-12 col-sm-3">
                    <div class="card card-box">
                        <div class="card-body">
                            <h4 class="card-title">{{trans('reception.enquiry')}}</h4>
                            <p class="card-text font-80pc">{{trans('reception.enquiry_module_description')}}</p>
                            <router-link to="/reception/enquiry" class="btn btn-info btn-sm">{{trans('general.go_to_link', {link: trans('reception.enquiry')})}}</router-link>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-3">
                    <div class="card card-box">
                        <div class="card-body">
                            <h4 class="card-title">{{trans('reception.visitor_log')}}</h4>
                            <p class="card-text font-80pc">{{trans('reception.visitor_log_module_description')}}</p>
                            <router-link to="/reception/visitor/log" class="btn btn-info btn-sm">{{trans('general.go_to_link', {link: trans('reception.visitor_log')})}}</router-link>
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