<template>
  <!---------------------------- Modal -->
  <div
    :class="modal ? 'modal fade in' : 'modal fade'"
    id="exampleModalCenter"
    tabindex="-1"
    role="dialog"
    aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true"
    data-keyboard="false"
    data-backdrop="true"
    :style="modal ? 'display: block;' : 'display: none;'"
  >
    <div class="modal-dialog2 modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          {{ flagButtonAdd ? "ADD" : "UPDATE" }} DATA {{ $root.judulHalaman }}
          <button
            id="closeModal"
            type="button"
            class="close"
            data-dismiss="modal"
            aria-label="Close"
            :disabled="$root.flagButtonLoading"
            @click="show_modal()"
          >
            <span aria-hidden="true">X</span>
          </button>
        </div>
        <div class="modal-body">
          <!-- <pre>{{ todo }}</pre> -->
          <!-- Wizards Row -->
          <div class="row">
            <div class="col-md-12">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="example-nf-email">Trans Number</label>
                  <CmpInputText
                    readonly
                    type="text"
                    placeholder="Trans Number"
                    v-model="todo.trans_number"
                    :class="
                      errorField.trans_number
                        ? 'form-control input-lg input-error'
                        : 'form-control input-lg'
                    "
                    :disabled="!flagButtonAdd"
                    @input="
                      (val) =>
                        (todo.trans_number = todo.trans_number.toUpperCase())
                    "
                  />
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                  <label for="example-nf-email">Project</label>
                  <CmpInputText
                    type="text"
                    placeholder="Project"
                    v-model="todo.project"
                    :class="
                      errorField.project
                        ? 'form-control input-lg input-error'
                        : 'form-control input-lg'
                    "
                    @input="
                      (val) => (todo.project = todo.project.toUpperCase())
                    "
                  />
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-12">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="example-nf-email">Customer</label>
                  <CmpInputText
                    type="text"
                    placeholder="Customer"
                    v-model="todo.customer"
                    :class="
                      errorField.customer
                        ? 'form-control input-lg input-error'
                        : 'form-control input-lg'
                    "
                    @input="
                      (val) => (todo.customer = todo.customer.toUpperCase())
                    "
                  />
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                  <label for="example-nf-email">Person In Charge</label>
                  <CmpInputText
                    type="text"
                    placeholder="Person In Charger"
                    v-model="todo.person_in_charge"
                    :class="
                      errorField.person_in_charge
                        ? 'form-control input-lg input-error'
                        : 'form-control input-lg'
                    "
                    @input="
                      (val) =>
                        (todo.person_in_charge =
                          todo.person_in_charge.toUpperCase())
                    "
                  />
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-12">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="example-nf-email">Job</label>
                  <CmpInputText
                    type="text"
                    placeholder="Job"
                    v-model="todo.job"
                    :class="
                      errorField.job
                        ? 'form-control input-lg input-error'
                        : 'form-control input-lg'
                    "
                    @input="(val) => (todo.job = todo.job.toUpperCase())"
                  />
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                  <label for="example-nf-email">Finance Manager</label>
                  <CmpInputText
                    type="text"
                    placeholder="Finance Manager"
                    v-model="todo.finance_manager"
                    :class="
                      errorField.finance_manager
                        ? 'form-control input-lg input-error'
                        : 'form-control input-lg'
                    "
                    @input="
                      (val) =>
                        (todo.finance_manager =
                          todo.finance_manager.toUpperCase())
                    "
                  />
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-12">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="example-nf-email">Acount Executive</label>
                  <CmpInputText
                    type="text"
                    placeholder="Acount Executive"
                    v-model="todo.acount_executive"
                    :class="
                      errorField.acount_executive
                        ? 'form-control input-lg input-error'
                        : 'form-control input-lg'
                    "
                    @input="
                      (val) =>
                        (todo.acount_executive =
                          todo.acount_executive.toUpperCase())
                    "
                  />
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                  <label for="example-nf-email">Acount Manager</label>
                  <CmpInputText
                    type="text"
                    placeholder="Acount Manager"
                    v-model="todo.acount_manager"
                    :class="
                      errorField.acount_manager
                        ? 'form-control input-lg input-error'
                        : 'form-control input-lg'
                    "
                    @input="
                      (val) =>
                        (todo.acount_manager =
                          todo.acount_manager.toUpperCase())
                    "
                  />
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-12">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="example-nf-email">Address</label>
                  <CmpInputText
                    type="text"
                    placeholder="Address"
                    v-model="todo.address"
                    :class="
                      errorField.address
                        ? 'form-control input-lg input-error'
                        : 'form-control input-lg'
                    "
                    @input="
                      (val) =>
                        (todo.address =
                          todo.address.toUpperCase())
                    "
                  />
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                  <label for="example-nf-email">Payment Status</label>
                  <select
                    v-model="todo.payment_status"
                    :class="errorField.payment_status ? 'form-control input-lg input-error' : 'form-control input-lg'"
                  >
                    <option disabled value="">Pilih Status Pembayaran</option>
                    <option value="Lunas">LUNAS</option>
                    <option value="Belum Lunas">BELUM LUNAS</option>
                  </select>
                </div>
              </div>

            </div>
          </div>

          <div class="row">
            <div class="col-md-12">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="example-nf-email">Jenis Pembayaran</label>
                  <select
                    v-model="todo.jenis_pembayaran"
                    :class="errorField.jenis_pembayaran ? 'form-control input-lg input-error' : 'form-control input-lg'"
                    @change="periksaJenisPembayaran"
                  >
                    <option disabled value="">Pilih Jenis Pembayaran</option>
                    <option value="Retainer">Retainer</option>
                    <option value="One Shoot Project">One Shoot Project</option>
                  </select>
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                  <label for="example-nf-email">Term</label>
                  <CmpInputText
                    type="number"
                    placeholder="Term"
                    :disabled="isTermDisabled"
                    v-model="todo.term"
                    :class="
                      errorField.term
                        ? 'form-control input-lg input-error'
                        : 'form-control input-lg'
                    "
                    @input="
                      (val) =>
                        (todo.term =
                          todo.term.toUpperCase())
                    "
                  />
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-12">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="example-nf-email">PPh 23</label>
                  <input
                      type="text"
                      class="form-control input-lg"
                      placeholder="Sudah Termasuk PPh 23"
                      disabled
                    />
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                  <label for="example-nf-email">PPn</label>
                  <select
                    v-model="todo.ppn"
                    :class="errorField.ppn ? 'form-control input-lg input-error' : 'form-control input-lg'"
                  >
                    <option disabled value="">Pilih Status PPn</option>
                    <option :value="true">Sudah Termasuk PPn </option>
                    <option :value="false">Belum Termasuk PPn</option>
                  </select>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-12">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="example-nf-email">Agency Fee</label>
                  <CmpInputText
                    type="number"
                    placeholder="Agency Fee"
                    v-model="todo.agency_fee"
                    :class="errorField.agency_fee ? 'form-control input-lg input-error' : 'form-control input-lg'"
                  />
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="example-nf-email">Discount</label>
                  <CmpInputText
                    type="number"
                    placeholder="Discount"
                    v-model="todo.discount"
                    :class="errorField.discount ? 'form-control input-lg input-error' : 'form-control input-lg'"
                    min="1"
                    max="100"
                    @input="validateDiscount"
                  />
                  <!-- Pesan Validasi -->
                  <span v-if="todo.discount < 1 || todo.discount > 100" style="color: red; font-size: 12px;">
                    Discount harus di antara 1 dan 100.
                  </span>
                </div>
              </div>

                 <!-- <div class="col-md-6">
                <div class="form-group">
                  <label for="example-nf-email">PPn Percent</label>
                  <CmpInputText
                    type="number"
                    placeholder="PPn Percent"
                    v-model="todo.ppn_percent"
                    :class="errorField.ppn_percent ? 'form-control input-lg input-error' : 'form-control input-lg'"
                  />
                </div>
              </div> -->

            </div>
          </div>

          <br />
          <br />
          <br />

          <div class="row" v-for="(input, k) in ratecardForm" :key="k">
            <div class="col-md-12">
              <div class="col-md-3">
                <div class="form-group">
                  <label for="example-nf-email">Rate Card</label>
                  <select
                    style="height: 50px"
                    class="form-control"
                    v-model="input.ratecard_id"
                    name="category_code"
                    id="category_code"
                    @change="updateNominal(k)"
                  >
                    <option
                      v-for="(item, index) in mstJobList"
                      :key="index"
                      :value="item.id"
                    >
                    {{ item.category_name }} - {{ item.job_description }}
                    </option>
                  </select>
                </div>
              </div>

              <div class="col-md-1">
                <div class="form-group">
                  <label for="example-nf-email">Quantity</label>
                  <CmpInputText
                    type="number"
                    placeholder="Nominal"
                    v-model="input.qty"
                    :class="
                      errorField.qty
                        ? 'form-control input-lg input-error'
                        : 'form-control input-lg'
                    "
                  />
                </div>
              </div>

              <div class="col-md-2">
                <div class="form-group">
                  <label for="example-nf-email">Nominal</label>
                  <CmpInputText
                  readonly
                    type="number"
                    placeholder="Nominal"
                    v-model="input.ratecard_nominal"
                    :class="
                      errorField.ratecard_nominal
                        ? 'form-control input-lg input-error'
                        : 'form-control input-lg'
                    "
                  />
                </div>
              </div>

              <div class="col-md-4">
                <div class="form-group">
                  <label for="example-nf-email">Note</label>
                  <CmpInputText
                    type="text"
                    placeholder="Note"
                    v-model="input.note"
                    :class="
                      errorField.note
                        ? 'form-control input-lg input-error'
                        : 'form-control input-lg'
                    "
                  />
                </div>
              </div>

              <div class="col-md-2">
                <div class="form-group">
                  <label for="example-nf-email">Tipe Usaha</label>
                  <select
                    v-model="ratecardForm[k].business_type"
                    :class="errorField.business_type ? 'form-control input-lg input-error' : 'form-control input-lg'"
                  >
                    <option value="Perorangan">Perorangan </option>
                    <option value="Badan Usaha">Badan Usaha</option>
                  </select>
                </div>
              </div>
            </div>

            <div class="col-md-12">
                <button
                  class="btn btn-danger btn-sm mt-3"
                  @click="removeSchedule(k)"
                  v-show="k || (!k && ratecardForm.length > 1)"
                >
                  Hapus Form
                </button>
                &nbsp;
                <button
                  class="btn btn-success btn-sm mt-3"
                  style="margin-left: -6px"
                  @click="addSchedule(k)"
                  v-show="k == ratecardForm.length - 1"
                >
                  Tambah Form
                </button>
              </div>

          </div>

          <!-- END Wizards Row -->
        </div>

        <div class="modal-footer">
          <div class="form-group form-actions">
            <div class="col-xs-12">
              <button
                v-if="flagButtonAdd"
                @click="saveTodo()"
                type="button"
                class="btn btn-sm btn-primary pull-left"
                :disabled="
                  $root.flagButtonLoading ||
                  todo.trans_number == null ||
                  todo.trans_number == '' ||
                  todo.customer == null ||
                  todo.customer == '' ||
                  // todo.trans_date == null ||
                  // todo.trans_date == '' ||
                  todo.person_in_charge == null ||
                  todo.person_in_charge == '' ||
                  todo.project == null ||
                  todo.project == '' ||
                  todo.job == null ||
                  todo.job == '' ||
                  todo.acount_executive == null ||
                  todo.acount_executive == '' ||
                  todo.acount_manager == null ||
                  todo.acount_manager == '' ||
                  todo.finance_manager == null ||
                  todo.finance_manager == '' ||
                  todo.payment_status == null ||
                  todo.payment_status == '' ||
                  todo.jenis_pembayaran == null ||
                  todo.jenis_pembayaran == '' ||
                  // todo.term == null ||
                  // todo.term == '' ||
                  // todo.pph23 == null ||
                  // todo.pph23 == '' ||
                  todo.ppn == null ||
                  // todo.ppn == '' ||
                  // todo.ppn_percent == null ||
                  // todo.ppn_percent == '' ||
                  todo.agency_fee == null ||
                  todo.agency_fee == '' 

                  // todo.ratecard_id == null ||
                  // todo.ratecard_id == '' ||
                  // todo.ratecard_nominal == null ||
                  // todo.ratecard_nominal == '' ||
                  // todo.note == null ||
                  // todo.note == ''
                "
              >
                <i
                  v-if="$root.flagButtonLoading"
                  class="fa fa-spinner fa-spin text-default"
                ></i>
                SAVE DATA
              </button>

              <button
                v-if="!flagButtonAdd"
                @click="editTodo()"
                type="button"
                class="btn btn-sm btn-primary pull-left"
                :disabled="
                  $root.flagButtonLoading ||
                  todo.trans_number == null ||
                  todo.trans_number == '' ||
                  todo.customer == null ||
                  todo.customer == '' ||
                  todo.trans_date == null ||
                  todo.trans_date == '' ||
                  todo.person_in_charge == null ||
                  todo.person_in_charge == '' ||
                  todo.project == null ||
                  todo.project == '' ||
                  todo.job == null ||
                  todo.job == '' ||
                  todo.acount_executive == null ||
                  todo.acount_executive == '' ||
                  todo.acount_manager == null ||
                  todo.acount_manager == '' ||
                  todo.finance_manager == null ||
                  todo.finance_manager == '' ||
                  todo.jenis_pembayaran == null ||
                  todo.jenis_pembayaran == '' ||
                  // todo.term == null ||
                  // todo.term == '' ||
                  todo.pph23 == null ||
                  // todo.pph23 == '' ||
                  todo.ppn == null ||
                  // todo.ppn == '' ||
                  // todo.ppn_percent == null ||
                  // todo.ppn_percent == '' ||
                  todo.agency_fee == null ||
                  todo.agency_fee == '' 
                "
              >
                <i
                  v-if="$root.flagButtonLoading"
                  class="fa fa-spinner fa-spin text-default"
                ></i>
                UPDATE DATA
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!---------------------------- Modal -->

  <!-- Page content -->
  <div id="page-content" v-if="isLogin == 1" style="min-height: 850px">
    <!-- END Visible Main Sidebar Header -->

    <!-- Block -->
    <div class="block">
      <!-- Block Title -->
      <div class="block-title">
        <h2>
          <strong>MENU {{ $root.judulHalaman }}</strong>
        </h2>

        <i v-if="!status_table" class="fa fa-spinner fa-spin text-default"></i>
      </div>
      <!-- END Block Title -->

      <div class="block-content">
        <!------------------------>
        <!-- Button trigger modal -->

        <button class="btn btn-sm btn-danger pull-left" @click="exportPdf()">
          Export PDF</button>
        <button
          v-if="status_table && $root.accessRoles[access_page].create"
          class="btn btn-sm btn-primary pull-right"
          @click="show_modal()"
        >
          ADD DATA
        </button>

        <!------------------------>
        <div id="wrapper2"></div>
        <div id="box"></div>
      </div>
      <!-- Block Content -->
      <!-- END Block Content -->
    </div>
    <!-- END Block -->
  </div>
</template>

<script>
import axios from "axios";
import { markRaw } from "vue";
import { Grid, h, html } from "gridjs";
import "gridjs/dist/theme/mermaid.css";
import { idID } from "gridjs/l10n";
import loadingBar from "@/assets/img/Moving_train.gif";
import { toast } from "vue3-toastify";
import "vue3-toastify/dist/index.css";
import { jsPDF } from "jspdf";
import autoTable from "jspdf-autotable";

export default {
  components: {
    // CmpSelect2,
    // LoadingX,
    // CmpInputText,
    // CmpInputText,
  },
  
  data() {
    return   {
      
      access_page: this.$root.decryptData(localStorage.getItem("halaman")),
      isLogin: localStorage.getItem("token") != null ? 1 : 0,
      activemenu: null,
      grid: new Grid(),
      // grid2: new Grid(),

      ratecardForm: [],
      mstJobList: [],

      errorField: {
        trans_number: false,
        customer: false,
        trans_date: false,
        person_in_charge: false,
        project: false,
        job: false,
        acount_executive: false,
        acount_manager: false,
        finance_manager: false,
        payment_status: false,
        jenis_pembayaran: false,
        term: false,
        pph23: false,
        ppn: false,
        ppn_percent: false,
        agency_fee: false,
        status: false,
        discount: false,
        ratecard: false,
        
      },

      userid: 0,
      status_table: false,

      modal: false,

      todo: {
        trans_number: "",
        customer: "",
        trans_date: "",
        person_in_charge: "",
        project: "",
        job: "",
        acount_executive: "",
        acount_manager: "",
        finance_manager: "",
        payment_status: "",
        jenis_pembayaran: "",
        term: "",
        pph23: "",
        ppn: "",
        ppn_percent: "",
        agency_fee: "",
        status: "",
        discount: "",
        ratecard: "",
      },

      flagButtonAdd: true,
      mstCategory: [],
      mstJobCategory: [],
      mstJobList: [],
      ratecardForm: [
      {
        id: "",
        ratecard_id: "",
        ratecard_nominal: "",
        note: "",
        business_type: "",
        qty: "",
      },
    ],
    deletedRatecards: [],

      json_fields: {
        trans_number: "trans_number",
        customer: "customer",
        trans_date: "trans_date",
        person_in_charge: "person_in_charge",
        address: "address",
        project: "project",
        job: "job",
        acount_executive: "acount_executive",
        acount_manager: "acount_manager",
        finance_manager: "finance_manager",
        payment_status: "payment_status",
        jenis_pembayaran: "jenis_pembayaran",
        term: "term",
        pph23: "pph23",
        ppn: "ppn",
        ppn_percent: "ppn_percent",
        agency_fee: "agency_fee",
        status: "status",
        discount: "discount",

      },
    };  
  },

    computed: {
      // Properti computed untuk disable/enable field term
      isTermDisabled() {
        return this.todo.jenis_pembayaran !== 'Retainer';
      },
    },

  

  async mounted() {
    // console.log(new Date().getFullYear() + '-' + (new Date().getMonth() + 1) + '-' + new Date().getDate());
    // await this.$root.refreshToken(localStorage.getItem("token"));
    this.getTable();
    this.getMasterCategory();
    this.getMasterJobCategory();
    this.getMasterJobList();
    this.generateCode();

    // this.userid = this.$root.get_id_user(localStorage.getItem("unique"));
    // this.userid = localStorage.getItem("userid");
    this.userid = "ADMIN";
  },
  methods: {

      // Pembatasan maks 100 pada input discount
      validateDiscount() {
          if (this.todo.discount < 1) {
            this.todo.discount = null;
          } else if (this.todo.discount > 100) {
            this.todo.discount = null;
          }
        },

      periksaJenisPembayaran() {
        // Reset nilai term jika jenis_pembayaran adalah "One Shoot Project"
        if (this.todo.jenis_pembayaran === 'One Shoot Project') {
          this.todo.term = '';
        }
      },

    async exportPdf() {
          const mythis = this;
          mythis.$root.presentLoading();

          try {
            let allData = [];
            let count = 1;
            let nn = 0;
            const limitx = 100;

            while (count > 0) {
              const offsetx = limitx * nn;

              const reqData = await axios({
                method: 'get',
                url: mythis.$root.apiHost + 'api/trx-header/getData?offset=' + offsetx + '&limit=' + limitx,
              });

              const resData = reqData.data;
              allData = [...allData, ...resData.results];

              if (resData.results.length === 0 || resData.results.length < limitx) {
                count = 0;
              }

              nn++;
              if (nn >= 100) {
                // Safety check to prevent infinite loop
                count = 0;
              }
            }

            const doc = new jsPDF();
            let totalPagesExp = '{total_pages_count_string}';

            doc.setFontSize(18);
            doc.text('Master Area Report', 14, 22);
            doc.setFontSize(11);
            doc.setTextColor(100);

            // Add Print Date
            doc.setFontSize(10);
            doc.text(`Print Date: ${new Date().toLocaleString()}`, 14, 30);

            doc.autoTable({
              theme: 'striped',
              head: [['No', 'Trans number', 'Customer', 'Trans Date', 'Payment Status', 'Person In Charge', 'Address', 'Project', 'Job', 'Acount Executive', 'Acount Manager', 'Finance Manager']],
              body: allData.map((transaction_header, index) => [index + 1, transaction_header.trans_number, transaction_header.customer, transaction_header.trans_date, transaction_header.payment_status, transaction_header.person_in_charge, transaction_header.address, transaction_header.project, transaction_header.job, transaction_header.acount_executive, transaction_header.acount_manager, transaction_header.finance_manager.toLocaleString()]),
              startY: 35, // Adjusted to accommodate the Print Date
              didDrawPage: function (data) {
                // Footer
                let str = 'Page ' + doc.internal.getNumberOfPages();
                if (typeof doc.putTotalPages === 'function') {
                  str = str + ' of ' + totalPagesExp;
                }
                doc.setFontSize(10);
                
                let pageSize = doc.internal.pageSize;
                let pageHeight = pageSize.height ? pageSize.height : pageSize.getHeight();
                doc.text(str, data.settings.margin.left, pageHeight - 10);
              },
              showHead: 'everyPage',
            });

            if (typeof doc.putTotalPages === 'function') {
              doc.putTotalPages(totalPagesExp);
            }

            const fileName = 'Master_Area_Report_' + mythis.formatDate(new Date()) + '.pdf';
            doc.save(fileName);
            console.log(fileName + ' generated');

            mythis.$root.stopLoading();
            Swal.fire('Success', 'PDF has been generated successfully', 'success');
          } catch (error) {
            console.error('Error generating PDF:', error);
            mythis.$root.stopLoading();
            Swal.fire('Error', 'Failed to generate PDF', 'error');
          }
        },

        padTo2Digits(num) {
          return num.toString().padStart(2, "0");
        },
        formatDate(date) {
          return (
            [
              date.getFullYear(),
              this.padTo2Digits(date.getMonth() + 1),
              this.padTo2Digits(date.getDate()),
            ].join("-") +
            " " +
            [
              this.padTo2Digits(date.getHours()),
              this.padTo2Digits(date.getMinutes()),
              this.padTo2Digits(date.getSeconds()),
            ].join(":")
          );
        },

      async exportPdf1(id) { 
        const mythis = this;
        mythis.$root.presentLoading();

          try {
              const reqData = await axios({
                  method: 'get',
                  url: mythis.$root.apiHost + `api/trx-header/${id}`,
              });

              const resData = reqData.data.data;
              const header = resData.header;
              const details = resData.ratecards;

              const pph23Text = header.pph23 ? "Sudah termasuk PPh 23" : "Belum termasuk PPh 23";
              const ppnText = header.ppn ? "Sudah termasuk PPN" : "Belum termasuk PPN";

              const doc = new jsPDF('p', 'pt', 'a4');

            
              const logo = new Image();
              logo.src = '/src/assets/img/creativestyle.jpeg'; 
              doc.addImage(logo, 'JPEG', 35, 20, 80, 80); 


              const boxX = 340;
              const boxY = 27;
              const boxWidth = 200; 
              const boxHeight = 15;

              doc.setFillColor(255, 153, 203); 
              doc.rect(boxX, boxY, boxWidth, boxHeight, 'F'); 

              doc.setFontSize(5);
              doc.setFont("helvetica", "bold");
              doc.setTextColor(0, 0, 0); 

              
              const jobText = `${header.job}`;
              let textX;
              if (jobText.length ) {
                  
                  textX = boxX + boxWidth / 2 - doc.getTextWidth(jobText) / 2;
              } else {
                  
                  textX = boxX + 10;
              }
              doc.text(jobText, textX, boxY + 10);
              
              doc.setFontSize(7);
              doc.text('PENAWARAN HARGA', 250, 100);

              const labelX = 40;
              const colonX = 230;
              const valueX = 250;
              doc.setFontSize(6);
              doc.setFont("helvetica", "normal");

              doc.text('Company', labelX, 130);
              doc.text(':', colonX, 130);
              doc.text(`${header.customer}`, valueX, 130);

              doc.text('Person In Charge', labelX, 150);
              doc.text(':', colonX, 150);
              doc.text(`${header.person_in_charge}`, valueX, 150);

              doc.text('Address', labelX, 170);
              doc.text(':', colonX, 170);
              const addressText = doc.splitTextToSize(`${header.address}`, 260); 
              doc.text(addressText, valueX, 170);
              
              doc.text('Project/Produk', labelX, 190);
              doc.text(':', colonX, 190);
              doc.text(`${header.project}`, valueX, 190);

              doc.text('Job', labelX, 210);
              doc.text(':', colonX, 210);
              doc.text(`${header.job}`, valueX, 210);

              doc.text('No Pesanan', labelX, 230);
              doc.text(':', colonX, 230);
              doc.text(`${header.trans_number}`, valueX, 230);


              
              const ratecards = details.map((detail, index) => {
              const totalAwal = parseFloat(detail.ratecard_nominal); 
              const totalAwalDenganQty = totalAwal * parseInt(detail.qty); 
              let totalAkhir;

              if  (detail.business_type === 'Perorangan') {
              totalAkhir = Math.floor(totalAwalDenganQty / 0.97 / 0.98);
              } 
              else if (detail.business_type === 'Badan Usaha') {
              totalAkhir = Math.floor(totalAwalDenganQty / 0.98);
              }

              return [
              index + 1,
              detail.job_description,
              `${detail.qty} master`,
              `Rp. ${new Intl.NumberFormat('en-US').format(totalAwal)}`,
              `Rp. ${new Intl.NumberFormat('en-US').format(totalAkhir)}    `,
              detail.note
          ];
        });

              const totalAkhirSum = details.reduce((sum, detail) => {
                const totalAwal = parseFloat(detail.ratecard_nominal) * parseInt(detail.qty);
                let totalAkhir = detail.business_type === 'Perorangan'
                    ? Math.floor(totalAwal / 0.97 / 0.98)
                    : Math.floor(totalAwal / 0.98);
                return sum + totalAkhir;
            }, 0);

              const agencyFeePercentage = header.agency_fee;
              const agencyFeeValue = Math.floor((totalAkhirSum * header.agency_fee) / 100);
              
              let totalBudget = totalAkhirSum + agencyFeeValue;

              let discountValue = 0; // Default diskon 0
                  if (header.discount && header.discount > 0) 
                    {
                        discountValue = Math.floor((totalAkhirSum + agencyFeeValue) * (header.discount / 100));
                        totalBudget = totalAkhirSum + agencyFeeValue - discountValue;
                    } 
                  else 
                    {
                        totalBudget = totalAkhirSum + agencyFeeValue; 
                    }

              const term = header.term || 1; // Default ke 1 jika term tidak ada
              const monthlyValue = Math.floor(totalBudget / term);
              const totalBudgetTerbilang = convertToTerbilang(totalBudget) + " Rupiah";
            
              
              ratecards.push(
                [
                  ratecards.length + 1,
                    `AGENCY FEE ${header.agency_fee}%`,
                    ``, 
                    ``, 
                    `Rp. ${new Intl.NumberFormat('id-ID').format(agencyFeeValue)}    `, 
                    `` 
                    
                  ]);
                

              doc.autoTable({
                  startY: 240,
                  head: [['No', '              Hal','','', '           Total  ', '                        Note']],
                  body: ratecards,
                  theme: 'plain',
                  styles: {
                      fontSize: 6,
                      fillColor: [255, 255, 255],
                      textColor: [0, 0, 0]
                  },
                  headStyles: {
                      fillColor: [255, 255, 255],
                      textColor: [0, 0, 0],
                  },
                  tableWidth: 500, 
                  columnStyles: {
                        0: { cellWidth: 20, fontStyle: 'bold' },       
                        1: { cellWidth: 130, fontStyle: 'bold' },   
                        2: { cellWidth: 50 },     
                        3: { cellWidth: 60, halign: 'right' },       
                        4: { cellWidth: 70 , halign: 'right' }, 
                        5: { cellWidth: 170 },      
                  },

                  didDrawCell: function (data) {
                      if (data.section === 'head') {
                          const doc = data.doc;
                          const cell = data.cell;

                          if (data.row.index === 0) {
                              doc.setLineWidth(1);
                              doc.setDrawColor(0, 0, 0); 
                              doc.line(cell.x, cell.y, cell.x + cell.width, cell.y);
                          }

                          if (data.row.index === 0 && data.cell.raw === 'Note', 'ratecard_nominal') {
                              doc.setLineWidth(2);
                              doc.setDrawColor(0, 0, 0); 
                              doc.line(cell.x, cell.y + cell.height, cell.x + cell.width  , cell.y + cell.height);
                          } 
                      }
                  }
                });

                
              let finalY = doc.lastAutoTable.finalY + 5;
              const pageWidth = doc.internal.pageSize.getWidth();

              doc.line(40, finalY -5, 540, finalY -5);

              if (header.discount && header.discount > 0) 
              {
                  doc.line(40, finalY - 4, 540, finalY - 4);
                  finalY += 5;

                  doc.setFont("helvetica", "bold");
                  doc.text(`Discount : ${header.discount}% `, 44, finalY);
                  doc.text(`Rp. ${new Intl.NumberFormat('id-ID').format(discountValue)}`, 358, finalY, { align: 'right' });
                  doc.setFont("helvetica", "normal");

                  finalY += 5; 
                  doc.line(40, finalY, 540, finalY);
                  finalY += 1; 
                  doc.line(40, finalY, 540, finalY);
                  finalY += 5; 
              }

              doc.setFont("helvetica", "bold"); // Set font menjadi bold
              doc.text('  TOTAL BUDGET :', 40, finalY + 5);
              doc.text(`Rp. ${new Intl.NumberFormat('id-ID').format(totalBudget)}`, pageWidth - 237, finalY + 5, { align: 'right' });
              doc.setFont("helvetica", "normal"); // Kembali ke font normal jika diperlukan
              
              doc.setDrawColor(0, 0, 0);
              finalY += 10;

              doc.line(40, finalY, 540, finalY);
              finalY += 1; 
              doc.line(40, finalY, 540, finalY);
              finalY += 8;

              
              // doc.text(`  Monthly : ${header.term} Month `, labelX, finalY + 20);
              if (header.jenis_pembayaran === "Retainer") 
              {
                
                  doc.setFillColor(255, 153, 203);
                  doc.rect(labelX, finalY + -8 , 500, 15, 'F');

                  doc.setFont("helvetica", "bold"); // Set font menjadi bold
                  doc.text(`  MONTHLY :`, labelX, finalY + 1);
                  doc.text(`Rp. ${new Intl.NumberFormat('id-ID').format(monthlyValue)}`, pageWidth - 237, finalY + 1, { align: 'right' });
                  doc.setFont("helvetica", "normal"); // Kembali ke font normal

                  finalY += 7; 
                  doc.line(40, finalY, 540, finalY);
                  finalY += 1; 
                  doc.line(40, finalY, 540, finalY);
                  finalY += 8; 
              }

              doc.text(`  Terbilang : ${totalBudgetTerbilang}`, labelX, finalY + 1);
              finalY += 8;
              doc.line(40, finalY, 540, finalY);
              finalY += 1; 
              doc.line(40, finalY, 540, finalY);

              finalY += 10; 

              doc.setFontSize(6);
              
              doc.text(`  ${pph23Text}`, labelX, finalY); 
              finalY += 15;
              const ppnTextWithPercent = `${ppnText} ${header.ppn_percent}%`;
              doc.text(`  ${ppnTextWithPercent}`, labelX, finalY);
              
              finalY += 15;
              doc.text(`  Pekerjaan akan dilakukan oleh CS setelah ada pembayaran DP minimal 50% dari Brand.`, labelX, finalY);
              finalY += 15;
              doc.text(`  Bila disetujui, mohon approval dari quotation ini di email, dan dikirimkan kembali ke CS.`, labelX, finalY);
              finalY += 15;
              doc.text(`  PO/PP segera dikeluarkan langsung setelah quotation di approve.`, labelX, finalY);

              
              // doc.line(labelX, finalY + 28, labelX + 500, finalY + 28);
              // doc.line(labelX, finalY + 29, labelX + 500, finalY + 29);


              // FUNCTION
              function convertToTerbilang(num) {
              const satuan = ["", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas"];
              if (num < 12) return satuan[num];
              if (num < 20) return satuan[num - 10] + " Belas";
              if (num < 100) return satuan[Math.floor(num / 10)] + " Puluh " + satuan[num % 10];
              if (num < 200) return "Seratus " + convertToTerbilang(num - 100);
              if (num < 1000) return satuan[Math.floor(num / 100)] + " Ratus " + convertToTerbilang(num % 100);
              if (num < 2000) return "Seribu " + convertToTerbilang(num - 1000);
              if (num < 1000000) return convertToTerbilang(Math.floor(num / 1000)) + " Ribu " + convertToTerbilang(num % 1000);
              if (num < 1000000000) return convertToTerbilang(Math.floor(num / 1000000)) + " Juta " + convertToTerbilang(num % 1000000);
              return convertToTerbilang(Math.floor(num / 1000000000)) + " Miliar " + convertToTerbilang(num % 1000000000);
              } 

              function capitalizeEachWord(text) {
                return text.toLowerCase().replace(/\b\w/g, char => char.toUpperCase());
              }
              
              
              finalY += 40;
              doc.text('Terima Kasih', 60, finalY );

              doc.setFontSize(7);
              
              doc.text(capitalizeEachWord(`${header.acount_executive}`), 55, finalY + 75);
              doc.text('Account Executive', 55, finalY + 85);

              doc.text(capitalizeEachWord(`${header.acount_manager}`), 200, finalY + 75);
              doc.text('Account Manager', 200, finalY + 85);

              doc.text(capitalizeEachWord(`${header.finance_manager}`), 300, finalY + 75);
              doc.text('Finance Manager', 300, finalY + 85);

              doc.setFontSize(7);
              doc.text('Tanggal', 400, finalY ); 
              doc.text('Disetujui Oleh : ', 400, finalY + 15);
              doc.text('Klien : ', 400, finalY + 85);

              // Simpan file PDF
              const fileName = `Quotation_${header.trans_number}.pdf`;
              doc.save(fileName);

              mythis.$root.stopLoading();
              Swal.fire('Success', 'PDF has been generated successfully', 'success');
          } catch (error) {
              console.error('Error generating PDF:', error);
              mythis.$root.stopLoading();
              Swal.fire('Error', 'Failed to generate PDF', 'error');
          }
    },

    // add form
    updateNominal(index) {
      // Cari nilai ratecard yang sesuai berdasarkan pilihan dari dropdown
      const selectedRatecard = this.mstJobList.find(
        (item) => item.id === this.ratecardForm[index].ratecard_id
      );
      // Jika ditemukan, update nilai nominal sesuai dengan ratecard
      if (selectedRatecard) {
        this.ratecardForm[index].ratecard_nominal = selectedRatecard.ratecard;
      }
    },
    
    addSchedule() {
      this.ratecardForm.push({
    id: "", // Pastikan ID kosong untuk data baru
    ratecard_id: "",
    ratecard_nominal: "",
    note: "",
    business_type: "",
    qty: "",
});
    },
    // remove form
    removeSchedule(index) {
    const form = this.ratecardForm[index];
    if (form.id) {
      // Jika form memiliki ID (berarti data lama), tambahkan ke deletedRatecards
      this.deletedRatecards.push(form.id);
    }
    this.ratecardForm.splice(index, 1); // Hapus dari ratecardForm
  },

    async getMasterJobList() {
      var mythis = this;
      mythis.$root.presentLoading();
      mythis.todo = {};
      const AuthStr = "bearer " + localStorage.getItem("token");
      const config = {
        headers: {
          Authorization: AuthStr,
        },
      };
      await axios
        .get(
          mythis.$root.apiHost + mythis.$root.prefixApi + `master-ratecard`,
          config
        )
        .then(async (res) => {
          const data = res.data.data;
          this.mstJobList = data;

          mythis.$root.stopLoading();
        });
    },

    async getMasterCategory() {
      var mythis = this;
      mythis.$root.presentLoading();
      mythis.todo = {};
      const AuthStr = "bearer " + localStorage.getItem("token");
      const config = {
        headers: {
          Authorization: AuthStr,
        },
      };
      await axios
        .get(
          mythis.$root.apiHost + mythis.$root.prefixApi + `master-categories`,
          config
        )
        .then(async (res) => {
          const data = res.data.data;
          this.mstCategory = data;

          mythis.$root.stopLoading();
        });
    },
    async getMasterJobCategory() {
      var mythis = this;
      mythis.$root.presentLoading();
      mythis.todo = {};
      const AuthStr = "bearer " + localStorage.getItem("token");
      const config = {
        headers: {
          Authorization: AuthStr,
        },
      };
      await axios
        .get(
          mythis.$root.apiHost + mythis.$root.prefixApi + `master-job-category`,
          config
        )
        .then(async (res) => {
          const data = res.data.data;
          this.mstJobCategory = data;

          mythis.$root.stopLoading();
        });
    },
    mySelectEvent() {
      this.todo.roles = this.tmp.cboRoles.code;
    },
    resetForm() {
      var mythis = this;
      Object.keys(mythis.errorField).forEach(function (key) {
        mythis.errorField[key] = false;
        mythis.todo[key] = "";
        //mythis.todo2[key] = "";
      });
      mythis.errorList = "";
    },
    refreshTable() {
      var mythis = this;
      mythis.status_table = false;
      //////////////////////////////
      $("#wrapper2").remove();
      var e = $('<div id="wrapper2"></div>');
      $("#box").append(e);
      this.getTable();
      //////////////////////////////
    },
    saveTodo() {
      var mythis = this;

      Swal.fire({
        title: "Create Document Status",
        text: "Are you sure?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes",
        cancelButtonText: "Cancel",
      }).then((result) => {
        if (result.isConfirmed) {
          /////////////////////////////////////////////////////////////////////
          // mythis.$root.presentLoading();
          mythis.$root.flagButtonLoading = true;
          const AuthStr = "bearer " + localStorage.getItem("token");
          const config = {
            headers: {
              Authorization: AuthStr,
            },
          };


          mythis.todo.ppn_percent = 11;
          mythis.todo.status = 0;
          mythis.todo.pph23 = true;

          var url =
            mythis.$root.apiHost + mythis.$root.prefixApi + "trx-header";
          axios
            .post(
              url,
              {
                trans_number: mythis.todo.trans_number,
                customer: mythis.todo.customer,
                person_in_charge: mythis.todo.person_in_charge,
                address: mythis.todo.address,
                project: mythis.todo.project,
                job: mythis.todo.job,
                acount_executive: mythis.todo.acount_executive,
                acount_manager: mythis.todo.acount_manager,
                finance_manager: mythis.todo.finance_manager,
                payment_status: mythis.todo.payment_status,
                jenis_pembayaran: mythis.todo.jenis_pembayaran,
                term: mythis.todo.term,
                pph23: mythis.todo.pph23,
                ppn: mythis.todo.ppn,
                ppn_percent: mythis.todo.ppn_percent,
                agency_fee: mythis.todo.agency_fee,
                status: mythis.todo.status,
                discount: mythis.todo.discount,
                created_by: mythis.userid,
                ratecard: mythis.ratecardForm,
                userid: mythis.userid,
              },
              config
            )
            .then((res) => {
              Swal.fire("Created!", res.data.message, "success");
              //mythis.$root.stopLoading();
              mythis.$root.flagButtonLoading = false;
              mythis.ratecardForm = [{
                ratecard_id: "",
                ratecard_nominal: "",
                note: "",
                business_type: "",
                qty: "",
              }]
              mythis.resetForm();
              mythis.generateCode();
              mythis.show_modal();
              mythis.refreshTable();
            })
            .catch(function (error) {
              mythis.$root.flagButtonLoading = false;
              if (error.response) {
                //console.log(error.response.data);
                if (error.response.status == 422) {
                  mythis.errorList = error.response.data;
                  // mythis.$root.loader = false;
                  if (Object.keys(mythis.errorList).length > 0) {
                    //refresh semua menjadi false
                    Object.keys(mythis.errorField).forEach(function (key) {
                      mythis.errorField[key] = false;
                    });
                    //membuat jika error jadi true
                    Object.keys(mythis.errorList).forEach(function (key) {
                      toast.error(mythis.errorList[key], { theme: "colored" });

                      // const myArray = key.split(".");
                      // mythis.errorField[myArray[1]] = true;
                      mythis.errorField[key] = true;
                    });
                  }
                } else {
                  toast.error(error.response.data.message, {
                    theme: "colored",
                  });
                }
              } else if (error.request) {
                console.log(error.request);
              } else {
                console.log("Error", error.message);
              }
            });
          /////////////////////////////////////////////////////////////////////
        }
      });
    },
    show_modal() {
      this.modal = !this.modal;
      if (this.modal == false) {
        this.flagButtonAdd = true;
        this.resetForm();
      }
    },
    async jqueryDelEdit() {
      const mythis = this;
      $(document).on("click", "#editData", async function () {
        let id = $(this).data("id");
        await mythis.getData(id);
        mythis.show_modal();
      });
      $(document).on("click", "#deleteData", function () {
        let id = $(this).data("id");
        mythis.deleteTodo(id);
      });
    },
    getTable() {
      var mythis = this;
      this.grid = new Grid();
      this.grid.updateConfig({
        pagination: {
          limit: 10,
          server: {
            url: (prev, page, limit) =>
              `${prev}${prev.includes("?") ? "&" : "?"}limit=${limit}&offset=${
                page * limit
              }`,
      },
    },
    search: {
      server: {
        url: (prev, keyword) => `${prev}?search=${keyword}`,
      },
    },
    columns: [
      { name: "ID", hidden: true },
      { name: "No", width: "50px" }, 
      { name: "TRANS NUMBER", width: "160px" }, 
      { name: "CUSTOMER", width: "150px" }, 
      { name: "TRANS DATE", width: "150px" },
      { name: "PERSON IN CHARGE", width: "180px" },
      { name: "ADDRESS", width: "300px" },
      { name: "PROJECT", width: "150px" },
      { name: "JOB", width: "150px" },
      { name: "ACOUNT EXECUTIVE", width: "180px" },
      { name: "ACOUNT MANAGER", width: "180px" },
      { name: "FINANCE MANAGER", width: "180px" },
      { name: "PAYMENT STATUS", width: "180px" },
      { name: "JENIS PEMBAYARAN", width: "190px" },
      {
        name: "TERM",
        width: "100px",
        formatter: (cell) => cell ? html(`<span class="pull-left">${cell} Month</span>`) : html(`<span class="pull-left"></span>`),
      },
      {
        name: "PPH 23",
        width: "150px",
        formatter: (cell) => (cell === true ? "Sudah termasuk PPh 23" : "Belum termasuk PPh 23"),
      },
      {
        name: "PPN",
        width: "150px",
        formatter: (cell) => (cell === true ? "Sudah termasuk PPn" : "Belum termasuk PPn"),
      },
      {
        name: "PPN PERCENT",
        width: "140px",
        formatter: (cell) => (cell !== null ? `${cell}%` : ''),
      },
      {
        name: "AGENCY FEE",
        width: "130px",
        formatter: (cell) => (cell !== null ? `${cell}%` : ''),
      },
      {
        name: "DISCOUNT",
        width: "120px",
        formatter: (cell) => (cell !== null ? `${cell}%` : ''),
      },
      {
        name: "Action",
        width: "120px",
        formatter: (_, row) =>
          mythis.$root.accessRoles[mythis.access_page].update &&
          mythis.$root.accessRoles[mythis.access_page].delete
            ? html(
                
              `<button data-id="${row.cells[0].data}" class="btn btn-sm btn-warning text-white" id="editData" data-toggle="tooltip" title="Edit" ><i class="fa fa-pencil-square-o"></i></button>
              &nbsp;&nbsp;&nbsp;
              <button data-id="${row.cells[0].data}" class="btn btn-sm btn-danger text-white" id="deleteData" data-toggle="tooltip" title="Delete" ><i class="fa fa-trash-o"></i></button>
               <button data-id="${row.cells[0].data}" class="btn btn-sm btn-success text-white" id="exportPdf1" data-toggle="tooltip" title="Export PDF" ><i class="fa fa-file-pdf-o"></i></button>`
            
              )
            : mythis.$root.accessRoles[mythis.access_page].update
            ? html(
                
              `<button data-id="${row.cells[0].data}" class="btn btn-sm btn-warning text-white" id="editData" data-toggle="tooltip" title="Edit" ><i class="fa fa-pencil-square-o"></i></button>
              <button data-id="${row.cells[0].data}" class="btn btn-sm btn-success text-white" id="exportPdf1" data-toggle="tooltip" title="Export PDF" ><i class="fa fa-file-pdf-o"></i></button>`
              )
            : mythis.$root.accessRoles[mythis.access_page].delete
            ? html(`&nbsp;&nbsp;&nbsp;
              <button data-id="${row.cells[0].data}" class="btn btn-sm btn-danger text-white" id="deleteData" data-toggle="tooltip" title="Delete" ><i class="fa fa-trash-o"></i></button>
              <button data-id="${row.cells[0].data}" class="btn btn-sm btn-success text-white" id="exportPdf1" data-toggle="tooltip" title="Export PDF" ><i class="fa fa-file-pdf-o"></i></button>
              `)
            : ``,
      },
    ],
    style: {
      table: {
          border: "1px solid #ccc",
          "table-layout": "fixed",
      },
      th: {
          "background-color": "rgba(0, 55, 255, 0.1)",
          color: "#000",
          "border-bottom": "1px solid #ccc",
          "text-align": "center",
      },
      td: {
          "white-space": "normal", 
          "word-wrap": "break-word", 
      },
  },
    server: {
      url: this.$root.apiHost + this.$root.prefixApi + "trx-header/getData",
      then: (data) =>
        data.results.map((card) => [
          card.id,
          data.nomorBaris++ + 1,
          html(`<span class="pull-left">${card.trans_number}</span>`),
          html(`<span class="pull-left">${card.customer}</span>`),
          html(`<span class="pull-left">${card.trans_date}</span>`),
          html(`<span class="pull-left">${card.person_in_charge}</span>`),
          html(`<span class="pull-left">${card.address}</span>`),
          html(`<span class="pull-left">${card.project}</span>`),
          html(`<span class="pull-left">${card.job}</span>`),
          html(`<span class="pull-left">${card.acount_executive}</span>`),
          html(`<span class="pull-left">${card.acount_manager}</span>`),
          html(`<span class="pull-left">${card.finance_manager}</span>`),
          html(`<span class="pull-left">${card.payment_status}</span>`),
          html(`<span class="pull-left">${card.jenis_pembayaran}</span>`),
          card.term,
          card.pph23,
          card.ppn,
          card.ppn_percent?.value || card.ppn_percent,
          card.agency_fee,
          card.discount
        ]),
      total: (data) => data.count,
      handle: (res) => {
        if (res.status === 404) return { data: [] };
        if (res.ok) return res.json();

        throw Error("oh no :(");
      },
    },
  });
      // DOM instead of vue selector because we are using vanilla JS
      this.grid.render(document.getElementById("wrapper2"));
      this.number = 0;

      $(document).off("click", "#editData");
      $(document).off("click", "#deleteData");
      $(document).off("click", "#exportPdf1");

      $(document).on("click", "#exportPdf1", function () {
        let id = $(this).data("id");
        mythis.exportPdf1(id); // Pass the transaction ID to export PDF
        });

      mythis.jqueryDelEdit();
      this.status_table = true;
    },
    deleteTodo(id) {
      var mythis = this;
      Swal.fire({
        title: "Delete Data",
        text: "Are you sure?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes",
        cancelButtonText: "Cancel",
      }).then((result) => {
        if (result.isConfirmed) {
          mythis.$root.presentLoading();
          const AuthStr = "bearer " + localStorage.getItem("token");
          const config = {
            headers: {
              Authorization: AuthStr,
            },
            data: {
              fileUpload: "form satuan",
              userid: mythis.userid,
            },
          };
          axios
            .delete(
              mythis.$root.apiHost +
                mythis.$root.prefixApi +
                `trx-header/${id}`,
              config
            )
            .then((res) => {
              //console.log(res.data.data);
              // /Swal.fire("Terhapus!", "Data telah sukses dihapus", "success");
              Swal.fire("Deleted!", "Data has been deleted", "success");

              mythis.$root.stopLoading();
              mythis.refreshTable();
              mythis.resetForm();
            });
        }
      });
    },

    editTodo() {
      var mythis = this;
      mythis.$root.flagButtonLoading = true;
      const AuthStr = "bearer " + localStorage.getItem("token");
      const config = {
        headers: {
          Authorization: AuthStr,
        },
      };
      axios
        .put(
          mythis.$root.apiHost +
            mythis.$root.prefixApi +
            "trx-header/" +
            mythis.todo.id,
          {
            trans_number: mythis.todo.trans_number,
            customer: mythis.todo.customer,
            trans_date: mythis.todo.trans_date,
            person_in_charge: mythis.todo.person_in_charge,
            address: mythis.todo.address,
            project: mythis.todo.project,
            job: mythis.todo.job,
            acount_executive: mythis.todo.acount_executive,
            acount_manager: mythis.todo.acount_manager,
            finance_manager: mythis.todo.finance_manager,
            payment_status: mythis.todo.payment_status,
            jenis_pembayaran: mythis.todo.jenis_pembayaran,
            term: mythis.todo.term,
            pph23: mythis.todo.pph23,
            ppn: mythis.todo.ppn,
            ppn_percent: mythis.todo.ppn_percent,
            agency_fee: mythis.todo.agency_fee,
            discount: mythis.todo.discount,
            created_by: mythis.userid,
            ratecard: mythis.ratecardForm,
            deletedRatecards: mythis.deletedRatecards,
            userid: mythis.userid,
          },
          config
        )
        .then((res) => {
          //console.log(res);
          //alert(res.data.message);
          Swal.fire("Updated!", res.data.message, "success");
          mythis.$root.flagButtonLoading = false;
          mythis.resetForm();
          mythis.show_modal();
          mythis.refreshTable();
        })
        .catch(function (error) {
          mythis.$root.flagButtonLoading = false;
          if (error.response) {
            //console.log(error.response.data);
            if (error.response.status == 422) {
              mythis.errorList = error.response.data;
              mythis.$root.loader = false;
              if (Object.keys(mythis.errorList).length > 0) {
                //refresh semua menjadi false
                Object.keys(mythis.errorField).forEach(function (key) {
                  mythis.errorField[key] = false;
                });
                //membuat jika error jadi true
                Object.keys(mythis.errorList).forEach(function (key) {
                  toast.error(mythis.errorList[key], { theme: "colored" });

                  // const myArray = key.split(".");
                  // mythis.errorField[myArray[1]] = true;
                  mythis.errorField[key] = true;
                });
              }
            } else {
              toast.error(error.response.data.message, {
                theme: "colored",
              });
            }
          } else if (error.request) {
            console.log(error.request);
          } else {
            console.log("Error", error.message);
          }
        });
    },

    async getData(id) {
      var mythis = this;
      mythis.flagButtonAdd = false;
      mythis.$root.presentLoading();
      mythis.todo = {};
      const AuthStr = "bearer " + localStorage.getItem("token");
      const config = {
        headers: {
          Authorization: AuthStr,
        },
      };
      await axios
        .get(
          mythis.$root.apiHost + mythis.$root.prefixApi + `trx-header/${id}`,
          config
        )
        .then(async (res) => {
          console.log(res.data.data);
          const data = res.data.data;
        
          mythis.todo.id = id;
          mythis.todo.trans_number = data.header.trans_number;
          mythis.todo.customer = data.header.customer;
          mythis.todo.trans_date = data.header.trans_date;
          mythis.todo.person_in_charge = data.header.person_in_charge;
          mythis.todo.address = data.header.address;
          mythis.todo.project = data.header.project;
          mythis.todo.job = data.header.job;
          mythis.todo.acount_executive = data.header.acount_executive;
          mythis.todo.acount_manager = data.header.acount_manager;
          mythis.todo.finance_manager = data.header.finance_manager;
          mythis.todo.payment_status = data.header.payment_status;
          mythis.todo.jenis_pembayaran = data.header.jenis_pembayaran;
          mythis.todo.term = data.header.term;
          mythis.todo.pph23 = data.header.pph23;
          mythis.todo.ppn = data.header.ppn;
          mythis.todo.ppn_percent = data.header.ppn_percent;
          mythis.todo.agency_fee = data.header.agency_fee;
          mythis.todo.status = data.header.status;
          mythis.todo.discount = data.header.discount;

          mythis.ratecardForm = data.ratecards.map((ratecard) => ({
            id: ratecard.id,
            ratecard_id: ratecard.ratecard_id,
            ratecard_nominal: ratecard.ratecard_nominal,
            note: ratecard.note,
            business_type: ratecard.business_type,
            qty: ratecard.qty,
          }));

          mythis.$root.stopLoading();
        })
        .catch((error) => {
          console.error("Error fetching data:", error);
        });
    },

    // generate trx code
    async generateCode(id) {
      var mythis = this;
      mythis.todo = {};
      const AuthStr = "bearer " + localStorage.getItem("token");
      const config = {
        headers: {
          Authorization: AuthStr,
        },
      };
      await axios
        .get(
          mythis.$root.apiHost + mythis.$root.prefixApi + `trx-header/generate-code`,
          config
        )
        .then(async (res) => {
          console.log(res.data);
          this.todo.trans_number = res.data;
          // console.log(res.data.data);
          // const data = res.data.data;
        });
    },
  },
};
</script>

<style scoped>
.input-error {
  border: red 1px solid;
}
</style>
