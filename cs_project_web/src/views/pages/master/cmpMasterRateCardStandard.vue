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
                    <label for="categorySelect">Category Name</label>
                    <select
                      id="categorySelect"
                      class="form-control"
                      v-model="selectedData"
                      @change="checkCost"
                    >
                      <option value="" disabled selected>-- Select Data --</option>
                      <option
                        v-for="(item, index) in options"
                        :key="index"
                        :value="item"
                        :class="!item.cost ? 'missing-cost' : ''"
                      >
                        {{ item.category_name }} - {{ item.job_category_name }} - 
                        {{ item.job_description }} - {{ item.ratecard }} - 
                        {{ item.cost || "COST MISSING" }}
                      </option>
                    </select>
                  </div>
                </div>

                <div class="col-md-6" v-if="showCostInput">
                  <div class="form-group">
                    <label for="costInput">Cost</label>
                    <input
                      type="number"
                      id="costInput"
                      class="form-control"
                      v-model="cost"
                      placeholder="Enter Cost"
                    />
                  </div>
                </div>
              </div>
            </div>
            <!-- END Wizards Row -->
          </div>
  

          
          
          <div class="modal-footer">
            <div class="form-group form-actions">
              <div class="col-xs-12">
                <button
                  @click="saveTodo"
                  type="button"
                  class="btn btn-sm btn-primary pull-left"
                  :disabled="!canSave"
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
                    todo.job_description == null ||
                    todo.job_description == '' ||
                    todo.ratecard == null ||
                    todo.ratecard == '' ||
                    todo.remarks == null ||
                    todo.remarks == ''
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
          <div class="col-md-3">
            <div class="form-group">
              <label for="example-nf-email">Categories</label>
              <select
                style="height: 50px"
                class="form-control"
                v-model="selectedCategory"
                @change="filterByCategory"
                id="categorySelect"
              >
              <option
                  v-for="(item, index) in mstCategory"
                  :key="index"
                  :value="item.category_code"
                >
                  {{ item.category_name }}
                </option>
              </select>
            </div>
          </div>
          <!------------------------>
          <!-- Button trigger modal -->
          <button
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
          category_code: false,
          job_category_code: false,
          job_description: false,
          ratecard: false,
          remarks: false,
          status: false,
        },
  
        userid: 0,
        status_table: false,
  
        modal: false,
  
        todo: {
          category_code: "",
          job_category_code: "",
          job_description: "",
          ratecard: "",
          remarks: "",
          status: true,
        },
        
        flagButtonAdd: true,
        mstCategory: [],
        mstJobCategory: [],
        selectedCategory: "",
        options: [], // Data untuk dropdown
        selectedData: null, // Data yang dipilih dari dropdown
        showCostInput: false, // Tampilkan input cost jika cost kosong
        cost: null, // Nilai input cost
      };
    },

    computed: {
        canSave() {
          // Hanya bisa save jika cost diisi
          return this.selectedData && (this.cost || this.selectedData.cost);
        },
      },


    async mounted() {
      // await this.$root.refreshToken(localStorage.getItem("token"));
      this.getTable();
      this.getMasterCategory();
      this.getMasterJobCategory();
      await this.fetchOptions();
      // this.userid = this.$root.get_id_user(localStorage.getItem("unique"));
      // this.userid = localStorage.getItem("userid");
      this.userid = 'ADMIN';
    },
    methods: {

      resetForm() {
      this.selectedData = null;
      this.showCostInput = false;
      this.cost = null;
    },

    async fetchOptions() {
      try {
        const response = await axios.get(
          `${this.$root.apiHost + this.$root.prefixApi}master-ratecard-standard/filter-data`
        );
        this.options = response.data.data;
      } catch (error) {
        console.error("Failed to fetch options:", error);
      }
    },
    
    checkCost() {
      if (this.selectedData && !this.selectedData.cost) {
        this.showCostInput = true;
      } else {
        this.showCostInput = false;
        this.cost = null;
      }
    },

    async saveData() {
      try {
        const payload = {
          ratecard_id: this.selectedData.id,
          cost: this.cost || this.selectedData.cost,
        };

        const response = await axios.post(
          `${this.$root.apiHost + this.$root.prefixApi}master-ratecard-standard`,
          payload
        );

        if (response.data.status) {
          alert("Data saved successfully!");
          this.show_modal();
          await this.fetchOptions();
        } else {
          alert("Failed to save data.");
        }
      } catch (error) {
        console.error("Failed to save data:", error);
      }
    },
  
      filterByCategory() {
      const selectedCategory = this.selectedCategory;
      if (selectedCategory) {
        // Ubah URL Grid.js untuk menyertakan filter category_code
        this.grid.updateConfig({
          server: {
            url: `${this.$root.apiHost + this.$root.prefixApi}master-ratecard/getData?category_code=${selectedCategory}`,
            then: (data) => data.results.map((card) => [
              card.id,
              data.nomorBaris++ + 1,
              html(`<span class="pull-left">${card.category_name}</span>`),
              html(`<span class="pull-left">${card.job_category_name}</span>`),
              html(`<span class="pull-left">${card.job_description}</span>`),
              html(`<span class="pull-right">${new Intl.NumberFormat('en-US').format(card.ratecard)}</span>`),
              html(`<span class="pull-left">${card.remarks}</span>`),
              html(`<span class="pull-left">${card.status == true ? '<i class="fa fa-check-square-o" aria-hidden="true"></i>' : '<i class="fa fa-times" aria-hidden="true"></i>'}</span>`),
            ]),
            total: (data) => data.count,
          },
        }).forceRender();
      } else {
        // Jika tidak ada kategori yang dipilih, tampilkan semua data
        this.getTable();
      }
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
        .get(mythis.$root.apiHost + mythis.$root.prefixApi +`master-categories`, config)
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
        .get(mythis.$root.apiHost + mythis.$root.prefixApi +`master-job-category`, config)
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
    const payload = {
        ratecard_id: this.selectedData.id, // Ambil ID dari dropdown yang dipilih
        cost: this.cost || this.selectedData.cost, // Gunakan cost baru atau yang sudah ada
    };

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
            this.$root.flagButtonLoading = true;
            const config = {
                headers: {
                    Authorization: "bearer " + localStorage.getItem("token"),
                },
            };

            axios.post(
                `${this.$root.apiHost + this.$root.prefixApi}master-ratecard-standard`,
                payload,
                config
            )
            .then((response) => {
                Swal.fire("Created!", response.data.message, "success");
                this.$root.flagButtonLoading = false;
                this.resetForm();
                this.show_modal(); // Tutup modal setelah berhasil menyimpan
                this.refreshTable(); // Refresh data di tabel
            })
            .catch((error) => {
                this.$root.flagButtonLoading = false;
                if (error.response) {
                    Swal.fire("Error!", error.response.data.message, "error");
                } else {
                    console.error("Error:", error.message);
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
            "CATEGORY",
            "TYPE",
            "JOB NAME",
            "RATE CARD",
            "COST",
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
            url: `${this.$root.apiHost + this.$root.prefixApi}master-ratecard-standard/indexx`,
            then: (data) =>
                data.data.map((card, index) => [
                    card.id,
                    index + 1,
                    html(`<span class="pull-left">${card.category_name}</span>`),
                    html(`<span class="pull-left">${card.job_category_name}</span>`),
                    html(`<span class="pull-left">${card.job_description}</span>`),
                    html(`<span class="pull-right">${new Intl.NumberFormat('en-US').format(card.ratecard)}</span>`),
                    html(`<span class="pull-right">${new Intl.NumberFormat('en-US').format(card.cost)}</span>`),
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
                mythis.$root.apiHost + mythis.$root.prefixApi +`master-ratecard/${id}`,
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
            mythis.$root.apiHost + mythis.$root.prefixApi +"master-ratecard/" + mythis.todo.id,
            {
              category_code: mythis.todo.category_code,
              job_category_code: mythis.todo.job_category_code,
              job_description: mythis.todo.job_description,
              ratecard: mythis.todo.ratecard,
              remarks: mythis.todo.remarks,
              status: mythis.todo.status,
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
        .get(mythis.$root.apiHost + mythis.$root.prefixApi +`master-ratecard/${id}`, config)
          .then(async (res) => {
            //console.log(res.data.data);
            //mythis.acuanEdit = id;
            //mythis.todo = res.data.data;
            mythis.todo.id = id;
            mythis.todo.category_code = res.data.data.category_code;
            mythis.todo.job_category_code = res.data.data.job_category_code;
            mythis.todo.job_description = res.data.data.job_description;
            mythis.todo.ratecard = res.data.data.ratecard;
            mythis.todo.remarks = res.data.data.remarks;
            mythis.todo.status = res.data.data.status;
  
            document.getElementById("inputA").focus(); // sets the focus on the input
  
            mythis.$root.stopLoading();
          });
      },
    },
  };
  </script>
  
  <style scoped>
  .input-error {
    border: red 1px solid;
  }

  .missing-cost {
    color: red;
  }
  </style>
  