<template>
	<div>
	    <form @submit.prevent="proceed" @keydown="transferCertificateForm.errors.clear($event.target.name)">
	        <div class="row">
	        	<div class="col-12">
	                <div class="form-group">
		            	<div class="input-group mb-3">
	                    	<input class="form-control" type="text" v-model="studentFilter.name" name="student_name" :placeholder="trans('student.student_search_by_name')">
							<div class="input-group-append">
								<button type="button" class="btn btn-info pull-right" @click="searchStudent"><i class="fas fa-search"></i> {{trans('general.search')}}</button>
							</div>
						</div>
	                </div>
	                <template v-if="students.total" class="m-b-10">
		            	<div class="table-responsive">
		            		<table class="table table-sm">
		            			<thead>
		            				<tr>
		            					<th>{{trans('student.name')}}</th>
		            					<th>{{trans('academic.batch')}}</th>
		            					<th>{{trans('student.father_name')}}</th>
		            					<th>{{trans('student.contact_number')}}</th>
		            					<th class="table-option"></th>
		            				</tr>
		            			</thead>
		            			<tbody>
		            				<tr v-for="student in students.data">
		            					<td>{{getStudentName(student)}}</td>
		            					<td>{{getStudentBatch(student)}}</td>
		            					<td>{{getStudentFatherName(student)}}</td>
		            					<td>{{student.contact_number}}</td>
		            					<td class="table-option">
		            						<button type="button" class="btn btn-sm btn-info" @click="selectStudent(student)">{{trans('student.select_student')}}</button>
		            					</td>
		            				</tr>
		            			</tbody>
		            		</table>
		            	</div>
		            	<pagination-record :page-length.sync="studentFilter.page_length" :records="students" @updateRecords="searchStudent"></pagination-record>
		            </template>

	            	<div class="m-b-20" v-if="selected_student">
	            		<div class="row">
	            			<div class="col-6">{{trans('student.name')+': '+getStudentName(selected_student)}}</div>
	            			<div class="col-6">{{trans('student.father_name')+': '+getStudentFatherName(selected_student)}} <br /></div>
	            			<div class="col-6">{{trans('academic.batch')+': '+getStudentBatch(selected_student)}}</div>
	            			<div class="col-6">{{trans('student.contact_number')+': '+selected_student.contact_number}}</div>
	            		</div>
	            	</div>

		            <div class="row">
			            <div class="col-12 col-sm-4">
			                <div class="form-group">
			                    <label for="">{{trans('academic.transfer_certificate_prefix')}}</label>
			                    <input class="form-control" type="text" v-model="transferCertificateForm.prefix" name="prefix" :placeholder="trans('academic.transfer_certificate_prefix')">
			                    <show-error :form-name="transferCertificateForm" prop-name="prefix"></show-error>
			                </div>
			            </div>
			            <div class="col-12 col-sm-4">
			                <div class="form-group">
			                    <label for="">{{trans('academic.transfer_certificate_number')}}</label>
			                    <input class="form-control" type="text" v-model="transferCertificateForm.number" name="number" :placeholder="trans('academic.transfer_certificate_number')">
			                    <show-error :form-name="transferCertificateForm" prop-name="number"></show-error>
			                </div>
			            </div>
			            <div class="col-12 col-sm-4">
			                <div class="form-group">
			                    <label for="">{{trans('academic.transfer_certificate_suffix')}}</label>
			                    <input class="form-control" type="text" v-model="transferCertificateForm.suffix" name="suffix" :placeholder="trans('academic.transfer_certificate_suffix')">
			                    <show-error :form-name="transferCertificateForm" prop-name="suffix"></show-error>
			                </div>
			            </div>
			            <div class="col-12 col-md-4">
			                <div class="form-group">
			                    <label for="">{{trans('academic.transfer_certificate_course_in_words')}}</label>
			                    <autosize-textarea v-model="transferCertificateForm.course_in_words" rows="1" name="course_in_words" :placeholder="trans('academic.transfer_certificate_course_in_words')"></autosize-textarea>
			                    <show-error :form-name="transferCertificateForm" prop-name="course_in_words"></show-error>
			                </div>
			            </div>
			            <div class="col-12 col-md-4">
			                <div class="form-group">
			                    <label for="">{{trans('academic.transfer_certificate_last_exam_with_result')}}</label>
			                    <autosize-textarea v-model="transferCertificateForm.last_exam_with_result" rows="1" name="last_exam_with_result" :placeholder="trans('academic.transfer_certificate_last_exam_with_result')"></autosize-textarea>
			                    <show-error :form-name="transferCertificateForm" prop-name="last_exam_with_result"></show-error>
			                </div>
			            </div>
			            <div class="col-12 col-md-4">
			                <div class="form-group">
			                    <label for="">{{trans('academic.transfer_certificate_is_last_exam_failed')}}</label>
			                    <autosize-textarea v-model="transferCertificateForm.is_last_exam_failed" rows="1" name="is_last_exam_failed" :placeholder="trans('academic.transfer_certificate_is_last_exam_failed')"></autosize-textarea>
			                    <show-error :form-name="transferCertificateForm" prop-name="is_last_exam_failed"></show-error>
			                </div>
			            </div>
			            <div class="col-12 col-md-4">
			                <div class="form-group">
			                    <label for="">{{trans('academic.transfer_certificate_qualified_for_promotion')}}</label>
			                    <autosize-textarea v-model="transferCertificateForm.qualified_for_promotion" rows="1" name="qualified_for_promotion" :placeholder="trans('academic.transfer_certificate_qualified_for_promotion')"></autosize-textarea>
			                    <show-error :form-name="transferCertificateForm" prop-name="qualified_for_promotion"></show-error>
			                </div>
			            </div>
			            <div class="col-12 col-md-4">
			                <div class="form-group">
			                    <label for="">{{trans('academic.transfer_certificate_subject_studied')}}</label>
			                    <autosize-textarea v-model="transferCertificateForm.subject_studied" rows="1" name="subject_studied" :placeholder="trans('academic.transfer_certificate_subject_studied')"></autosize-textarea>
			                    <show-error :form-name="transferCertificateForm" prop-name="subject_studied"></show-error>
			                </div>
			            </div>
			            <div class="col-12 col-md-4">
			                <div class="form-group">
			                    <label for="">{{trans('academic.transfer_certificate_third_language')}}</label>
			                    <autosize-textarea v-model="transferCertificateForm.third_language" rows="1" name="third_language" :placeholder="trans('academic.transfer_certificate_third_language')"></autosize-textarea>
			                    <show-error :form-name="transferCertificateForm" prop-name="third_language"></show-error>
			                </div>
			            </div>
			            <div class="col-12 col-md-4">
			                <div class="form-group">
			                    <label for="">{{trans('academic.transfer_certificate_fee_paid_upto')}}</label>
			                    <autosize-textarea v-model="transferCertificateForm.fee_paid_upto" rows="1" name="fee_paid_upto" :placeholder="trans('academic.transfer_certificate_fee_paid_upto')"></autosize-textarea>
			                    <show-error :form-name="transferCertificateForm" prop-name="fee_paid_upto"></show-error>
			                </div>
			            </div>
			            <div class="col-12 col-md-4">
			                <div class="form-group">
			                    <label for="">{{trans('academic.transfer_certificate_working_days')}}</label>
			                    <autosize-textarea v-model="transferCertificateForm.working_days" rows="1" name="working_days" :placeholder="trans('academic.transfer_certificate_working_days')"></autosize-textarea>
			                    <show-error :form-name="transferCertificateForm" prop-name="working_days"></show-error>
			                </div>
			            </div>
			            <div class="col-12 col-md-4">
			                <div class="form-group">
			                    <label for="">{{trans('academic.transfer_certificate_present_days')}}</label>
			                    <autosize-textarea v-model="transferCertificateForm.present_days" rows="1" name="present_days" :placeholder="trans('academic.transfer_certificate_present_days')"></autosize-textarea>
			                    <show-error :form-name="transferCertificateForm" prop-name="present_days"></show-error>
			                </div>
			            </div>
			            <div class="col-12 col-md-4">
			                <div class="form-group">
			                    <label for="">{{trans('academic.transfer_certificate_cocurricular_activities')}}</label>
			                    <autosize-textarea v-model="transferCertificateForm.cocurricular_activities" rows="1" name="cocurricular_activities" :placeholder="trans('academic.transfer_certificate_cocurricular_activities')"></autosize-textarea>
			                    <show-error :form-name="transferCertificateForm" prop-name="cocurricular_activities"></show-error>
			                </div>
			            </div>
			            <div class="col-12 col-md-4">
			                <div class="form-group">
			                    <label for="">{{trans('academic.transfer_certificate_general_conduct')}}</label>
			                    <autosize-textarea v-model="transferCertificateForm.general_conduct" rows="1" name="general_conduct" :placeholder="trans('academic.transfer_certificate_general_conduct')"></autosize-textarea>
			                    <show-error :form-name="transferCertificateForm" prop-name="general_conduct"></show-error>
			                </div>
			            </div>
			            <div class="col-12 col-md-4">
			                <div class="form-group">
			                    <label for="">{{trans('academic.transfer_certificate_date_of_application')}}</label>
                    			<datepicker v-model="transferCertificateForm.date_of_application" :bootstrapStyling="true" @selected="transferCertificateForm.errors.clear('date_of_application')" :placeholder="trans('academic.transfer_certificate_date_of_application')"></datepicker>
			                    <show-error :form-name="transferCertificateForm" prop-name="date_of_application"></show-error>
			                </div>
			            </div>
			            <div class="col-12 col-md-4">
			                <div class="form-group">
			                    <label for="">{{trans('academic.transfer_certificate_date_of_issue')}}</label>
                    			<datepicker v-model="transferCertificateForm.date_of_issue" :bootstrapStyling="true" @selected="transferCertificateForm.errors.clear('date_of_issue')" :placeholder="trans('academic.transfer_certificate_date_of_issue')"></datepicker>
			                    <show-error :form-name="transferCertificateForm" prop-name="date_of_issue"></show-error>
			                </div>
			            </div>
			            <div class="col-12 col-md-4">
			                <div class="form-group">
			                    <label for="">{{trans('academic.transfer_certificate_reason')}}</label>
			                    <autosize-textarea v-model="transferCertificateForm.reason" rows="1" name="reason" :placeholder="trans('academic.transfer_certificate_reason')"></autosize-textarea>
			                    <show-error :form-name="transferCertificateForm" prop-name="reason"></show-error>
			                </div>
			            </div>
			            <div class="col-12 col-md-4">
			                <div class="form-group">
			                    <label for="">{{trans('academic.transfer_certificate_admission_in_institute')}}</label>
			                    <autosize-textarea v-model="transferCertificateForm.admission_in_institute" rows="1" name="admission_in_institute" :placeholder="trans('academic.transfer_certificate_admission_in_institute')"></autosize-textarea>
			                    <show-error :form-name="transferCertificateForm" prop-name="admission_in_institute"></show-error>
			                </div>
			            </div>
			            <div class="col-12 col-md-4">
			                <div class="form-group">
			                    <label for="">{{trans('academic.transfer_certificate_remarks')}}</label>
			                    <autosize-textarea v-model="transferCertificateForm.remarks" rows="1" name="remarks" :placeholder="trans('academic.transfer_certificate_remarks')"></autosize-textarea>
			                    <show-error :form-name="transferCertificateForm" prop-name="remarks"></show-error>
			                </div>
			            </div>
			        </div>

	            	<button type="submit" v-if="transferCertificateForm.student_record_id" class="btn btn-info">{{trans('general.save')}}</button>
	        	</div>
	        </div>
	    </form>
	</div>
</template>

<script>
    import vSelect from 'vue-multiselect'
    import datepicker from 'vuejs-datepicker'

	export default {
		components: {vSelect,datepicker},
		props: ['uuid'],
		data() {
			return {
				transferCertificateForm: new Form({
					student_record_id: '',
					number: '',
					prefix: '',
					suffix: '',
					course_in_words: '',
					last_exam_with_result: '',
					is_last_exam_failed: '',
					qualified_for_promotion: '',
					subject_studied: '',
					third_language: '',
					fee_paid_upto: '',
					working_days: '',
					present_days: '',
					cocurricular_activities: '',
					general_conduct: '',
					date_of_application: '',
					date_of_issue: '',
					reason: '',
					admission_in_institute: '',
					remarks: '',
				}),
				selected_student: null,
				studentFilter: {
					name: '',
					page_length: helper.getConfig('page_length')
				},
				students: {
					data: [],
					total: 0
				}
			}
		},
		mounted(){

			if (this.uuid)
				this.get();
		},
		methods: {
            getStudentName(student){
                return helper.getStudentName(student);
            },
            getStudentFatherName(student){
            	return student.parent.father_name;
            },
            getStudentBatch(student){
            	let student_record = student.student_records[0];
            	return student_record.batch.course.name+' '+student_record.batch.name;
            },
			searchStudent(page){
				let loader = this.$loading.show();
                if (typeof page !== 'number') {
                    page = 1;
                }
                let url = helper.getFilterURL(this.studentFilter);
				axios.get('/api/student/search/name?page=' + page + url)
					.then(response => {
						this.students = response;

						if(! response.total) {
							loader.hide();
							return toastr.error(i18n.general.no_search_result_found);
						}
						loader.hide();
					})
					.catch(error => {
						loader.hide();
						helper.showErrorMsg(error);
					})
			},
			selectStudent(student){
				this.transferCertificateForm.student_record_id = student.student_records[0].id;
				this.selected_student = student;
				this.students = [];
				this.studentFilter.name = '';
			},
            proceed(){
                if(this.uuid)
                    this.update();
                else
                    this.store();
            },
            store(){
                let loader = this.$loading.show();
                this.transferCertificateForm.date_of_application = helper.toDate(this.transferCertificateForm.date_of_application);
                this.transferCertificateForm.date_of_issue = helper.toDate(this.transferCertificateForm.date_of_issue);
                this.transferCertificateForm.post('/api/transfer-certificate')
                    .then(response => {
                        toastr.success(response.message);
                        this.selected_student = null;
                        this.$emit('completed');
                        loader.hide();
                    })
                    .catch(error => {
                        loader.hide();
                        helper.showErrorMsg(error);
                    });
            },
            get(){
                let loader = this.$loading.show();
                axios.get('/api/transfer-certificate/'+this.uuid)
                    .then(response => {
                        this.transferCertificateForm.student_record_id = response.transfer_certificate.student_record_id;
                    	this.selected_student = response.transfer_certificate.student_record.student;
                    	this.selected_student.student_records = [response.transfer_certificate.student_record];
                    	this.selected_student.parent = response.transfer_certificate.student_record.student.parent;

                        this.transferCertificateForm.prefix = response.transfer_certificate.prefix;
                        this.transferCertificateForm.number = response.transfer_certificate.number;
                        this.transferCertificateForm.suffix = response.transfer_certificate.suffix;
                        this.transferCertificateForm.course_in_word = response.transfer_certificate.course_in_word;
                        this.transferCertificateForm.last_exam_with_result = response.transfer_certificate.last_exam_with_result;
                        this.transferCertificateForm.is_last_exam_failed = response.transfer_certificate.is_last_exam_failed;
                        this.transferCertificateForm.qualified_for_promotion = response.transfer_certificate.qualified_for_promotion;
                        this.transferCertificateForm.subject_studied = response.transfer_certificate.subject_studied;
                        this.transferCertificateForm.third_language = response.transfer_certificate.third_language;
                        this.transferCertificateForm.fee_paid_upto = response.transfer_certificate.fee_paid_upto;
                        this.transferCertificateForm.working_days = response.transfer_certificate.working_days;
                        this.transferCertificateForm.present_days = response.transfer_certificate.present_days;
                        this.transferCertificateForm.cocurricular_activities = response.transfer_certificate.cocurricular_activities;
                        this.transferCertificateForm.general_conduct = response.transfer_certificate.general_conduct;
                        this.transferCertificateForm.date_of_application = response.transfer_certificate.date_of_application;
                        this.transferCertificateForm.date_of_issue = response.transfer_certificate.date_of_issue;
                        this.transferCertificateForm.reason = response.transfer_certificate.reason;
                        this.transferCertificateForm.admission_in_institute = response.transfer_certificate.admission_in_institute;
                        this.transferCertificateForm.remarks = response.transfer_certificate.remarks;

	                    loader.hide();
                    })
                    .catch(error => {
                        // loader.hide();
                        // helper.showErrorMsg(error);
                        // this.$router.push('/academic/transfer-certificate');
                    });
            },
            update(){
                let loader = this.$loading.show();
                this.transferCertificateForm.date_of_application = helper.toDate(this.transferCertificateForm.date_of_application);
                this.transferCertificateForm.date_of_issue = helper.toDate(this.transferCertificateForm.date_of_issue);
                this.transferCertificateForm.patch('/api/transfer-certificate/'+this.uuid)
                    .then(response => {
                        toastr.success(response.message);
                        loader.hide();
                        this.$router.push('/academic/transfer-certificate');
                    })
                    .catch(error => {
                        loader.hide();
                        helper.showErrorMsg(error);
                    });
            }
		},
		computed: {

		},
		filters: {

		},
		watch: {
		}
	}
</script>