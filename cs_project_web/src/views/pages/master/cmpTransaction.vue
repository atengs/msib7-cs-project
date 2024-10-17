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
                  <label for="example-nf-email">Payment Status</label>
                  <CmpInputText
                    type="text"
                    placeholder="Payment Status"
                    v-model="todo.payment_status"
                    :class="
                      errorField.payment_status
                        ? 'form-control input-lg input-error'
                        : 'form-control input-lg'
                    "
                    @input="
                      (val) =>
                        (todo.payment_status =
                          todo.payment_status.toUpperCase())
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
                  <label for="example-nf-email">Trans Date</label>
                  <CmpInputText
                    type="Date"
                    placeholder="Trans Date"
                    v-model="todo.trans_date"
                    :class="
                      errorField.trans_date
                        ? 'form-control input-lg input-error'
                        : 'form-control input-lg'
                    "
                    @input="
                      (val) => (todo.trans_date = todo.trans_date.toUpperCase())
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

          <br />
          <br />
          <br />

          <div class="row" v-for="(input, k) in ratecardForm" :key="k">
            <div class="col-md-12">
              <div class="col-md-4">
                <div class="form-group">
                  <label for="example-nf-email">Rate Card</label>
                  <select
                    style="height: 50px"
                    class="form-control"
                    v-model="input.ratecard_id"
                    name="category_code"
                    id="category_code"
                  >
                    <option
                      v-for="(item, index) in mstJobList"
                      :key="index"
                      :value="item.id"
                    >
                      {{ item.job_description }}
                    </option>
                  </select>
                </div>
              </div>

              <div class="col-md-4">
                <div class="form-group">
                  <label for="example-nf-email">Nominal</label>
                  <CmpInputText
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
                  todo.trans_date == null ||
                  todo.trans_date == '' ||
                  todo.payment_status == null ||
                  todo.payment_status == '' ||
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
                  todo.finance_manager == ''

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
                  todo.payment_status == null ||
                  todo.payment_status == '' ||
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
                  todo.finance_manager == ''
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

export default {
  components: {
    // CmpSelect2,
    // LoadingX,
    // CmpInputText,
    // CmpInputText,
  },
  data() {
    return {
      access_page: this.$root.decryptData(localStorage.getItem("halaman")),
      isLogin: localStorage.getItem("token") != null ? 1 : 0,
      activemenu: null,
      grid: new Grid(),
      // grid2: new Grid(),
      errorField: {
        trans_number: false,
        customer: false,
        trans_date: false,
        payment_status: false,
        person_in_charge: false,
        project: false,
        job: false,
        acount_executive: false,
        acount_manager: false,
        finance_manager: false,
        ratecard: false,
      },

      userid: 0,
      status_table: false,

      modal: false,

      todo: {
        trans_number: "",
        customer: "",
        trans_date: "",
        payment_status: "",
        person_in_charge: "",
        project: "",
        job: "",
        acount_executive: "",
        acount_manager: "",
        finance_manager: "",
        ratecard: "",
      },

      flagButtonAdd: true,
      mstCategory: [],
      mstJobCategory: [],
      mstJobList: [],
      ratecardForm: [
        {
          ratecard_id: "",
          ratecard_nominal: "",
          note: "",
        },
      ],
    };
  },
  async mounted() {
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
    // add form
    addSchedule() {
      this.ratecardForm.push({
        ratecard_id: "",
        ratecard_nominal: "",
        note: "",
      });
    },
    // remove form
    removeSchedule(index) {
      this.ratecardForm.splice(index, 1);
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
          mythis.$root.apiHost + mythis.$root.prefixApi + `master-job-list`,
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
          var url =
            mythis.$root.apiHost + mythis.$root.prefixApi + "trx-header";
          axios
            .post(
              url,
              {
                trans_number: mythis.todo.trans_number,
                customer: mythis.todo.customer,
                trans_date: mythis.todo.trans_date,
                payment_status: mythis.todo.payment_status,
                person_in_charge: mythis.todo.person_in_charge,
                project: mythis.todo.project,
                job: mythis.todo.job,
                acount_executive: mythis.todo.acount_executive,
                acount_manager: mythis.todo.acount_manager,
                finance_manager: mythis.todo.finance_manager,
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
              }]
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
        // language: idID,
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
          "No",
          "TRANS NUMBER",
          "CUSTOMER",
          "TRANS DATE",
          "PAYMENT STATUS",
          "PERSON IN CHARGE",
          "PROJECT",
          "JOB",
          "ACOUNT EXECUTIVE",
          "ACOUNT MANAGER",
          "FINANCE MANAGER",
          {
            name: "Action",
            formatter: (_, row) =>
              mythis.$root.accessRoles[mythis.access_page].update &&
              mythis.$root.accessRoles[mythis.access_page].delete
                ? html(
                    `
                  <button data-id="${row.cells[0].data}" class="btn btn-sm btn-warning text-white" id="editData" data-toggle="tooltip" title="Edit" ><i class="fa fa-pencil-square-o"></i></button>
                  &nbsp;&nbsp;&nbsp;
                  <button data-id="${row.cells[0].data}" class="btn btn-sm btn-danger text-white" id="deleteData" data-toggle="tooltip" title="Delete" ><i class="fa fa-trash-o"></i></button>
                `
                  )
                : mythis.$root.accessRoles[mythis.access_page].update
                ? html(
                    `
                  <button data-id="${row.cells[0].data}" class="btn btn-sm btn-warning text-white" id="editData" data-toggle="tooltip" title="Edit" ><i class="fa fa-pencil-square-o"></i></button>`
                  )
                : mythis.$root.accessRoles[mythis.access_page].delete
                ? html(`&nbsp;&nbsp;&nbsp;
                  <button data-id="${row.cells[0].data}" class="btn btn-sm btn-danger text-white" id="deleteData" data-toggle="tooltip" title="Delete" ><i class="fa fa-trash-o"></i></button>`)
                : ``,
          },
        ],
        style: {
          table: {
            border: "1px solid #ccc",
          },
          th: {
            "background-color": "rgba(0, 55, 255, 0.1)",
            color: "#000",
            "border-bottom": "1px solid #ccc",
            "text-align": "center",
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
              html(`<span class="pull-left">${card.payment_status}</span>`),
              html(`<span class="pull-left">${card.person_in_charge}</span>`),
              html(`<span class="pull-left">${card.project}</span>`),
              html(`<span class="pull-left">${card.job}</span>`),
              html(`<span class="pull-left">${card.acount_executive}</span>`),
              html(`<span class="pull-left">${card.acount_manager}</span>`),
              html(`<span class="pull-left">${card.finance_manager}</span>`),
            ]),
          total: (data) => data.count,
          handle: (res) => {
            // no matching records found
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
            payment_status: mythis.todo.payment_status,
            person_in_charge: mythis.todo.person_in_charge,
            project: mythis.todo.project,
            job: mythis.todo.job,
            acount_executive: mythis.todo.acount_executive,
            acount_manager: mythis.todo.acount_manager,
            finance_manager: mythis.todo.finance_manager,
            created_by: mythis.userid,
            ratecard: mythis.ratecardForm,
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
          //mythis.acuanEdit = id;
          //mythis.todo = res.data.data;
          mythis.todo.id = id;
          mythis.todo.trans_number = data.trans_number;
          mythis.todo.customer = data.customer;
          mythis.todo.trans_date = data.trans_date;
          mythis.todo.payment_status = data.payment_status;
          mythis.todo.person_in_charge = data.person_in_charge;
          mythis.todo.project = data.project;
          mythis.todo.job = data.job;
          mythis.todo.acount_executive = data.acount_executive;
          mythis.todo.acount_manager = data.acount_manager;
          mythis.todo.finance_manager = data.finance_manager;

          // document.getElementById("inputA").focus(); // sets the focus on the input

          mythis.$root.stopLoading();
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
          console.log(res.data.data);
          const data = res.data.data;
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
