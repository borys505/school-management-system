<template>
    <div>
        <div class="page-titles">
            <div class="row">
                <div class="col-12 col-sm-6">
                    <h3 class="text-themecolor">{{trans('academic.transfer_certificate')}} 
                        <span class="card-subtitle d-none d-sm-inline" v-if="transfer_certificates.total">{{trans('general.total_result_found',{count : transfer_certificates.total, from: transfer_certificates.from, to: transfer_certificates.to})}}</span>
                        <span class="card-subtitle d-none d-sm-inline" v-else>{{trans('general.no_result_found')}}</span>
                    </h3>
                </div>
                <div class="col-12 col-sm-6">
                    <div class="action-buttons pull-right">
                        <button class="btn btn-info btn-sm" v-if="hasPermission('create-transfer-certificate')" @click="$router.push('/academic/transfer-certificate/create')" v-tooltip="trans('general.add_new')"><i class="fas fa-plus"></i> <span class="d-none d-sm-inline">{{trans('academic.add_new_transfer_certificate')}}</span></button>
                        <button class="btn btn-info btn-sm" v-if="!showFilterPanel" @click="showFilterPanel = !showFilterPanel"><i class="fas fa-filter"></i> <span class="d-none d-sm-inline">{{trans('general.filter')}}</span></button>
                        <sort-by :order-by-options="orderByOptions" :sort-by="filter.sort_by" :order="filter.order" @updateSortBy="value => {filter.sort_by = value}"  @updateOrder="value => {filter.order = value}"></sort-by>
                        <div class="btn-group">
                            <button type="button" class="btn btn-info btn-sm dropdown-toggle no-caret " role="menu" id="moreOption" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-tooltip="trans('general.more_option')">
                                <i class="fas fa-ellipsis-h"></i> <span class="d-none d-sm-inline"></span>
                            </button>
                            <div :class="['dropdown-menu',getConfig('direction') == 'ltr' ? 'dropdown-menu-right' : '']" aria-labelledby="moreOption">
                                <button class="dropdown-item custom-dropdown" @click="print"><i class="fas fa-print"></i> {{trans('general.print')}}</button>
                                <button class="dropdown-item custom-dropdown" @click="pdf"><i class="fas fa-file-pdf"></i> {{trans('general.generate_pdf')}}</button>
                            </div>
                        </div>
                        <help-button @clicked="help_topic = 'academic.transfer_certificate'"></help-button>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <transition name="fade">
                <div class="card card-form" v-if="showFilterPanel">
                    <div class="card-body">
                        <h4 class="card-title">{{trans('general.filter')}}</h4>
                        <div class="row">
                            <div class="col-12 col-sm-6">
                                <date-range-picker :start-date.sync="filter.date_of_issue_start_date" :end-date.sync="filter.date_of_issue_end_date" :label="trans('academic.date_of_issue_between')"></date-range-picker>
                            </div>
                        </div>
                        <div class="card-footer text-right">
                            <button type="button" @click="showFilterPanel = false" class="btn btn-danger">{{trans('general.cancel')}}</button>
                            <button type="button" class="btn btn-info waves-effect waves-light" @click="getTransferCertificates">{{trans('general.filter')}}</button>
                        </div>
                    </div>
                </div>
            </transition>
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive" v-if="transfer_certificates.total">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th v-if="filter.type != 'employee'">{{trans('student.student')}}</th>
                                    <th>{{trans('academic.date_of_issue')}}</th>
                                    <th>{{trans('academic.date_of_application')}}</th>
                                    <th>{{trans('general.created_at')}}</th>
                                    <th class="table-option">{{trans('general.action')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="transfer_certificate in transfer_certificates.data">
                                    <td>
                                        {{getStudentName(transfer_certificate.student_record.student)}} <br /> {{getStudentBatch(transfer_certificate.student_record)}}
                                    </td>
                                    <td>{{transfer_certificate.date_of_issue | moment}}</td>
                                    <td>{{transfer_certificate.date_of_application | moment}}</td>
                                    <td>{{transfer_certificate.created_at | momentDateTime}}</td>
                                    <td class="table-option">
                                        <div class="btn-group">
                                            <a target="_blank" :href="`/academic/transfer-certificate/${transfer_certificate.uuid}/print?token=${authToken}`" v-tooltip="trans('general.print')" class="btn btn-success btn-sm">
                                                <i class="fas fa-print"></i>
                                            </a>
                                            <button class="btn btn-info btn-sm" v-if="hasPermission('edit-transfer-certificate')" v-tooltip="trans('academic.edit_transfer_certificate')" @click.prevent="editTransferCertificate(transfer_certificate)"><i class="fas fa-edit"></i></button>
                                            <button class="btn btn-danger btn-sm" v-if="hasPermission('delete-transfer-certificate')" :key="transfer_certificate.id" v-confirm="{ok: confirmDelete(transfer_certificate)}" v-tooltip="trans('academic.delete_transfer_certificate')"><i class="fas fa-trash"></i></button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <module-info v-if="!transfer_certificates.total" module="academic" title="transfer_certificate_module_title" description="transfer_certificate_module_description" icon="list"></module-info>
                    <pagination-record :page-length.sync="filter.page_length" :records="transfer_certificates" @updateRecords="getTransferCertificates"></pagination-record>
                </div>
            </div>
        </div>
        <right-panel :topic="help_topic"></right-panel>
    </div>
</template>

<script>
    import vSelect from 'vue-multiselect'
    import datepicker from 'vuejs-datepicker'

    export default {
        components : { datepicker,vSelect},
        data() {
            return {
                transfer_certificates: {
                    total: 0,
                    data: []
                },
                filter: {
                    sort_by : 'date_of_issue',
                    order: 'desc',
                    date_of_issue_start_date: '',
                    date_of_issue_end_date: '',
                    page_length: helper.getConfig('page_length')
                },
                orderByOptions: [
                    {
                        value: 'date_of_issue',
                        translation: i18n.academic.date_of_issue
                    },
                    {
                        value: 'date_of_application',
                        translation: i18n.academic.date_of_application
                    }
                ],
                showFilterPanel: false,
                help_topic: ''
            };
        },
        mounted(){
            if(!helper.hasPermission('list-transfer-certificate')){
                helper.notAccessibleMsg();
                this.$router.push('/dashboard');
            }

            this.getTransferCertificates();
        },
        methods: {
            hasPermission(permission){
                return helper.hasPermission(permission);
            },
            getStudentName(student){
                return helper.getStudentName(student);
            },
            getStudentBatch(student_record){
                return student_record.batch.course.name+' '+student_record.batch.name;
            },
            getTransferCertificates(page){
                let loader = this.$loading.show();
                if (typeof page !== 'number') {
                    page = 1;
                }
                let url = helper.getFilterURL(this.filter);
                axios.get('/api/transfer-certificate?page=' + page + url)
                    .then(response => {
                        this.transfer_certificates = response.transfer_certificates;
                        loader.hide();
                    })
                    .catch(error => {
                        loader.hide();
                        helper.showErrorMsg(error);
                    });
            },
            editTransferCertificate(transfer_certificate){
                this.$router.push('/academic/transfer-certificate/'+transfer_certificate.uuid+'/edit');
            },
            confirmDelete(transfer_certificate){
                return dialog => this.deleteTransferCertificate(transfer_certificate);
            },
            deleteTransferCertificate(transfer_certificate){
                let loader = this.$loading.show();
                axios.delete('/api/transfer-certificate/'+transfer_certificate.uuid)
                    .then(response => {
                        toastr.success(response.message);
                        this.getTransferCertificates();
                        loader.hide();
                    }).catch(error => {
                        loader.hide();
                        helper.showErrorMsg(error);
                    });
            },
            getConfig(config) {
                return helper.getConfig(config)
            },
            print(){
                let loader = this.$loading.show();
                axios.post('/api/transfer-certificate/print',{filter: this.filter})
                    .then(response => {
                        let print = window.open("/print");
                        loader.hide();
                        print.document.write(response);
                    })
                    .catch(error => {
                        loader.hide();
                        helper.showErrorMsg(error);
                    });
            },
            pdf(){
                let loader = this.$loading.show();
                axios.post('/api/transfer-certificate/pdf',{filter: this.filter})
                    .then(response => {
                        loader.hide();
                        window.open('/download/report/'+response+'?token='+this.authToken);
                    })
                    .catch(error => {
                        loader.hide();
                        helper.showErrorMsg(error);
                    });
            }
        },
        filters: {
          moment(date) {
            return helper.formatDate(date);
          },
          momentDateTime(date) {
            return helper.formatDateTime(date);
          }
        },
        watch: {
            'filter.sort_by': function(val){
                this.getTransferCertificates();
            },
            'filter.order': function(val){
                this.getTransferCertificates();
            },
            'filter.page_length': function(val){
                this.getTransferCertificates();
            }
        },
        computed: {
            authToken(){
                return helper.getAuthToken();
            }
        }
    }
</script>