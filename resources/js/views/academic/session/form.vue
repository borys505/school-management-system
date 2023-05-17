<template>
    <form @submit.prevent="proceed" @keydown="academicSessionForm.errors.clear($event.target.name)">
        <div class="row">
            <div class="col-12 col-sm-3">
                <div class="form-group">
                    <label for="">{{trans('academic.session_name')}}</label>
                    <input class="form-control" type="text" v-model="academicSessionForm.name" name="name" :placeholder="trans('academic.session_name')">
                    <show-error :form-name="academicSessionForm" prop-name="name"></show-error>
                </div>
            </div>
            <div class="col-12 col-sm-3">
                <div class="form-group">
                    <label for="">{{trans('academic.session_start_date')}}</label>
                    <datepicker v-model="academicSessionForm.start_date" :bootstrapStyling="true" @selected="academicSessionForm.errors.clear('start_date')" :placeholder="trans('academic.session_start_date')" :disabled="id ? true : false"></datepicker>
                    <show-error :form-name="academicSessionForm" prop-name="start_date"></show-error>
                </div>
            </div>
            <div class="col-12 col-sm-3">
                <div class="form-group">
                    <label for="">{{trans('academic.session_end_date')}}</label>
                    <datepicker v-model="academicSessionForm.end_date" :bootstrapStyling="true" @selected="academicSessionForm.errors.clear('end_date')" :placeholder="trans('academic.session_end_date')" :disabled="id ? true : false"></datepicker>
                    <show-error :form-name="academicSessionForm" prop-name="end_date"></show-error>
                </div>
            </div>
            <div class="col-12 col-sm-3">
                <div class="form-group">
                    <label for="">{{trans('academic.session_description')}}</label>
                    <autosize-textarea v-model="academicSessionForm.description" rows="1" name="description" :placeholder="trans('academic.session_description')"></autosize-textarea>
                    <show-error :form-name="academicSessionForm" prop-name="description"></show-error>
                </div>
            </div>
        </div>
        <template v-if="!setupWizard">
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <switches class="m-l-20" v-model="academicSessionForm.is_default" theme="bootstrap" color="success"></switches> {{trans('academic.session_is_default')}}
                    </div>
                </div>
            </div>

            <div class="card-footer text-right">
                <router-link to="/academic/session" class="btn btn-danger waves-effect waves-light " v-show="id">{{trans('general.cancel')}}</router-link>
                <button v-if="!id" type="button" class="btn btn-danger waves-effect waves-light " @click="$emit('cancel')">{{trans('general.cancel')}}</button>
                <button type="submit" class="btn btn-info waves-effect waves-light">
                    <span v-if="id">{{trans('general.update')}}</span>
                    <span v-else>{{trans('general.save')}}</span>
                </button>
            </div>
        </template>
    </form>
</template>


<script>
    import switches from 'vue-switches'
    import datepicker from 'vuejs-datepicker'

    export default {
        props: {
            setupWizard: {
                default: false
            },
            id: ''
        },
        components: {switches,datepicker},
        data() {
            return {
                academicSessionForm: new Form({
                    name : '',
                    description : '',
                    start_date: '',
                    end_date: '',
                    is_default: 0
                })
            };
        },
        mounted() {
            if(!helper.hasPermission('create-academic-session') && !helper.hasPermission('edit-academic-session')){
                helper.notAccessibleMsg();
                this.$router.push('/dashboard');
            }

            if(this.id)
                this.get();
        },
        methods: {
            proceed(){
                if(this.id)
                    this.update();
                else
                    this.store();
            },
            store(){
                let loader = this.$loading.show();
                this.academicSessionForm.start_date = helper.toDate(this.academicSessionForm.start_date);
                this.academicSessionForm.end_date = helper.toDate(this.academicSessionForm.end_date);
                this.academicSessionForm.post('/api/academic/session')
                    .then(response => {
                        this.$store.dispatch('setAcademicSession',response.academic_sessions);
                        toastr.success(response.message);
                        this.$emit('completed');
                        loader.hide();
                        if (this.setupWizard)
                            this.$router.push('/dashboard');
                    })
                    .catch(error => {
                        loader.hide();
                        helper.showErrorMsg(error);
                    });
            },
            get(){
                let loader = this.$loading.show();
                axios.get('/api/academic/session/'+this.id)
                    .then(response => {
                        this.academicSessionForm.name = response.name;
                        this.academicSessionForm.description = response.description;
                        this.academicSessionForm.start_date = response.start_date;
                        this.academicSessionForm.end_date = response.end_date;
                        this.academicSessionForm.is_default = response.is_default;
                        loader.hide();
                    })
                    .catch(error => {
                        loader.hide();
                        helper.showErrorMsg(error);
                        this.$router.push('/academic/session');
                    });
            },
            update(){
                let loader = this.$loading.show();
                this.academicSessionForm.start_date = helper.toDate(this.academicSessionForm.start_date);
                this.academicSessionForm.end_date = helper.toDate(this.academicSessionForm.end_date);
                this.academicSessionForm.patch('/api/academic/session/'+this.id)
                    .then(response => {
                        this.$store.dispatch('setConfig',{loaded: false});
                        toastr.success(response.message);
                        loader.hide();
                        this.$router.push('/academic/session');
                    })
                    .catch(error => {
                        loader.hide();
                        helper.showErrorMsg(error);
                    });
            }
        }
    }
</script>
