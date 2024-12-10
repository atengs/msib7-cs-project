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
                <!-- Trans Number Dropdown -->
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="example-nf-email">Trans Number</label>
                    <select
                      style="height: 50px"
                      class="form-control"
                      v-model="todo.trans_number"
                      @change="updateTotal"
                      name="trans_number"
                      id="trans_number"
                    >
                      <option
                        v-for="(item, index) in mstTransaction_header"
                        :key="index"
                        :value="item.trans_number"
                      >
                        {{ item.trans_number }} - {{ item.customer }} - {{ item.project }}
                      </option>
                    </select>
                  </div>
                </div>  

                <!-- Total Field -->
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="example-nf-email">Total</label>
                    <div
                      class="form-control"
                      style="background-color: #f5f5f5;"
                      readonly
                    >
                     Rp.  {{ formatCurrency(todo.total) }}
                    </div>
                  </div>
                </div>
              </div>
            </div>


            <div class="row">
              <div class="col-md-12">
                <!-- Due Date -->
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="due_date">Due Date</label>
                    <input
                      type="text"
                      class="form-control"
                      v-model="todo.due_date"
                      id="due_date"
                      required
                    />
                  </div>
                </div>

                <!-- Dibayarkan -->
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="total_invoice">Dibayarkan</label>
                    <input
                      type="number"
                      class="form-control"
                      v-model="todo.total_invoice"
                      id="total_invoice"
                      placeholder="Masukkan jumlah pembayaran"
                      min="0"
                      required
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
                  v-if="flagButtonAdd"
                  @click="saveTodo()"
                  type="button"
                  class="btn btn-sm btn-primary pull-left"
                  :disabled="
                    $root.flagButtonLoading ||
                    todo.trans_number == null ||
                    todo.trans_number == '' ||
                    todo.due_date == null ||
                    todo.due_date == '' ||
                    todo.total_invoice == null ||
                    todo.total_invoice == '' 
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
                    todo.due_date == null ||
                    todo.due_date == '' ||
                    todo.total_invoice == null ||
                    todo.total_invoice == '' 
            
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
       
  
        errorField: {
          trans_number: false,
          due_date: false,
          total_invoice: false,
        },
  
        userid: 0,
        status_table: false,
  
        modal: false,
  
        todo: {
         
          trans_number: "",
          due_date: "",
          total_invoice: "",
        },
  
        flagButtonAdd: true,
        mstCategory: [],
        mstJobCategory: [],
        mstJobList: [],
        deletedRatecards: [],
        mstTransaction_header: [],

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
      await this.getTransactionHeader();

      // Jika data tersedia, unduh PDF berdasarkan data pertama
      if (this.mstTransaction_header.length > 0) {
        const firstTransaction = this.mstTransaction_header[0]; // Data pertama
        if (firstTransaction && firstTransaction.id) {
          await this.exportInvoice(firstTransaction.id); // Unduh PDF
        }
      }

      this.getTable();
      this.getMasterCategory();
      this.getMasterJobCategory();
      this.getMasterJobList();
      this.generateCode();
      this.getTransactionHeader();
  
      // this.userid = this.$root.get_id_user(localStorage.getItem("unique"));
      // this.userid = localStorage.getItem("userid");
      this.userid = "ADMIN";
    },
    methods: {

      formatCurrency(value) {
        if (!value) return "0";
        return new Intl.NumberFormat("id-ID", {
          style: "decimal",
          minimumFractionDigits: 0,
        }).format(value);
      },

        updateTotal() {
          const selectedItem = this.mstTransaction_header.find(
            (item) => item.trans_number === this.todo.trans_number
          );
          this.todo.total = selectedItem ? selectedItem.total : ""; // Isi total berdasarkan Trans Number
        },
  
  
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


    async getTransactionHeader() {
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
      .get(mythis.$root.apiHost + mythis.$root.prefixApi +`trx-header`, config)
        .then(async (res) => {
          const data = res.data.data;
          this.mstTransaction_header = data;

          mythis.$root.stopLoading();
        });
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
  
          async exportInvoice(id) { 
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
                const invoice = resData.invoice;

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
  
  
                doc.setFontSize(11);
                doc.setFont("helvetica", "bold");
                doc.setTextColor(0, 0, 0); 
                
                
                
                const maxWidth = boxWidth; // Lebar maksimum teks
                let fontSize = 8; // Ukuran font default

                // Fungsi untuk menurunkan ukuran font jika teks terlalu panjang
                function adjustFontSize(text, maxWidth, initialFontSize, doc) {
                    let currentFontSize = initialFontSize;
                    let wrappedText = doc.splitTextToSize(text, maxWidth);

                    while (wrappedText.length > 1 && currentFontSize > 7) { // Batas minimum ukuran font adalah 6
                        currentFontSize--;
                        doc.setFontSize(currentFontSize);
                        wrappedText = doc.splitTextToSize(text, maxWidth);
                    }
                    return { fontSize: currentFontSize, wrappedText };
                }

                // CLIENT
                const jobText = `CLIENT : `;
                doc.setFontSize(fontSize);
                doc.text(jobText, boxX, boxY + 10);

                // CUSTOMER
                const customerText = `${header.customer}`;
                let adjustedCustomer = adjustFontSize(customerText, maxWidth, fontSize, doc);
                doc.setFontSize(adjustedCustomer.fontSize);
                doc.text(adjustedCustomer.wrappedText, boxX, boxY + 25);

                // ADDRESS
                const addressText = `${header.address}`;
                let adjustedAddress = adjustFontSize(addressText, maxWidth, fontSize, doc);
                doc.setFontSize(adjustedAddress.fontSize);
                doc.text(adjustedAddress.wrappedText, boxX, boxY + 40);





                
                                



                doc.setFontSize(10);
                doc.text(`ATTN ${header.person_in_charge}`, 250, 100);
  
                const labelX = 40;
                const colonX = 230;
                const valueX = 250;
                doc.setFontSize(9);
                doc.setFont("helvetica", "normal");
  
                doc.text('INVOICE NO', labelX, 130);
                doc.text(':', colonX, 130);
                doc.text(`${invoice ? invoice.invoice_number : '-'}`, valueX, 130);
  
                doc.text('ORDER NO', labelX, 150);
                doc.text(':', colonX, 150);
                doc.text(`${header.trans_number}`, valueX, 150);
                
                doc.text('KETERANGAN', labelX, 170);
                doc.text(':', colonX, 170);
                doc.text(`${header.job}`, valueX, 170);
  
                doc.text('INVOICE DATE', labelX, 190);
                doc.text(':', colonX, 190);
                doc.text(`${header.ppn}`, valueX, 190);
  
                doc.text('DUE DATE', labelX, 210);
                doc.text(':', colonX, 210);
                doc.text(`${invoice ? invoice.due_date : '-'}`, valueX, 210);
  
  
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////    

                const ratecards = details.map((detail, index) => {
                const totalratecardnominal = parseFloat(detail.ratecard_nominal); 
                const totalratecardnominalqty = totalratecardnominal * parseInt(detail.qty); 
                const totalAkhir = totalratecardnominalqty;

                return [
                        index + 1,
                        detail.job_description,
                        ``,
                        `Rp. ${new Intl.NumberFormat('en-US').format(totalratecardnominalqty)}            `
                    ];
                });
  
                const totalSumseluruhratecardnominal = details.reduce((sum, detail) => {
                    const totalratecardnominal = parseFloat(detail.ratecard_nominal) * parseInt(detail.qty);
                    const totalAkhir = totalratecardnominal;
                    return sum + totalAkhir;
                }, 0);
  
                
                const agencyFeeValue = Math.floor((totalSumseluruhratecardnominal * header.agency_fee) / 100);
                
                
                let subTotal = totalSumseluruhratecardnominal ;
                let totalExcludingtax = totalSumseluruhratecardnominal + agencyFeeValue ;
                const totalppnpercent = Math.floor((totalExcludingtax * header.ppn_percent) / 100);
                let totalInvoice = totalExcludingtax + totalppnpercent ;  
                 

                const totalBudgetTerbilang = convertToTerbilang(totalInvoice) + " Rupiah";
              
          
          
            ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////      
                

                

                    ratecards.push(
                      [ 
                        '', // Kolom "No" dibiarkan kosong
                      ``,
                      { content: 'Sub Total', styles: { fontStyle: 'bold' } },
                      { content: `Rp. ${new Intl.NumberFormat('id-ID').format(totalSumseluruhratecardnominal)}            `, styles: { fontStyle: 'bold' } }
                      
                    ]);

                    
                    ratecards.push(
                  [
                      '',
                      ``,
                      `Job External Total `, 
                      `Rp. ${new Intl.NumberFormat('id-ID').format(totalSumseluruhratecardnominal)}            `
                      
                    ]);

                    ratecards.push(
                  [
                      '',
                      ``,
                      `Agency Fee `, 
                      `Rp. ${new Intl.NumberFormat('id-ID').format(agencyFeeValue)}            `
                      
                    ]);

                    ratecards.push(
                  [
                      '',
                      ``,
                      `Total Excluding Tax `, 
                      `Rp. ${new Intl.NumberFormat('id-ID').format(totalExcludingtax)}            `
                      
                    ]);

                    ratecards.push(
                  [
                      '',
                      ``,
                      `VAT ${header.ppn_percent}% `, 
                      `Rp. ${new Intl.NumberFormat('id-ID').format(totalppnpercent)}            `
                      
                    ]);

                    ratecards.push(
                  [
                  '',
                  '', 
                  { content: 'INVOICE TOTAL', styles: { fontStyle: 'bold' } }, 
                  { content: `Rp. ${new Intl.NumberFormat('id-ID').format(totalInvoice)}            `, styles: { fontStyle: 'bold' } }
    ]);

                    
                 
                  
  ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

                doc.autoTable({
                    startY: 240,
                    head: [['No', '        Description','','                       Ratecard'  ]],
                    body: ratecards,
                    theme: 'plain',
                    styles: {
                        fontSize: 9,
                        fillColor: [255, 255, 255],
                        textColor: [0, 0, 0]
                    },
                    headStyles: {
                        fillColor: [255, 255, 255],
                        textColor: [0, 0, 0],
                    },
                    tableWidth: 500, 
                    columnStyles: {
                          0: { cellWidth: 50, fontStyle: 'bold' },       
                          1: { cellWidth: 190, fontStyle: 'bold' },   
                          2: { cellWidth: 100 },     
                          3: { cellWidth: 160, halign: 'right' },       
                               
                    },
  
                    didDrawCell: function (data) {
                    const doc = data.doc;
                    const cell = data.cell;

                    // Garis untuk header tabel
                    if (data.section === 'head') {
                        if (data.row.index === 0) {
                            doc.setLineWidth(1);
                            doc.setDrawColor(0, 0, 0); 
                            doc.line(cell.x, cell.y, cell.x + cell.width, cell.y);
                        }

                        if (data.row.index === 0 && data.cell.raw === 'Note', 'ratecard_nominal') {
                            doc.setLineWidth(2);
                            doc.setDrawColor(0, 0, 0); 
                            doc.line(cell.x, cell.y + cell.height, cell.x + cell.width, cell.y + cell.height);
                        }
                    }

                    // Garis di bawah "Sub Total"
                    if (data.row.raw && data.row.raw[2] && data.row.raw[2].content === 'Sub Total') {
                        const startX = cell.x;
                        const endX = cell.x + cell.width;
                        const lineY = cell.y + cell.height;

                        // Tambahkan garis horizontal di bawah baris "Sub Total"
                        doc.setLineWidth(1);
                        doc.setDrawColor(0, 0, 0);
                        doc.line(startX, lineY, endX, lineY);
                    }
                }
              });
  
                  
                let finalY = doc.lastAutoTable.finalY + 1;
                const pageWidth = doc.internal.pageSize.getWidth();

                doc.line(40, finalY + -23, 540, finalY + -23); // Garis pertama
                
                doc.line(40, finalY + -22, 540, finalY + -22); 
  
                // doc.setFont("helvetica", "bold"); // Set font menjadi bold
                // doc.text('  Sub Total :', 40, finalY + 5);
                // doc.text(`Rp. ${new Intl.NumberFormat('id-ID').format(subTotal)}`, pageWidth - 237, finalY + 5, { align: 'right' });
                // doc.setFont("helvetica", "normal"); // Kembali ke font normal jika diperlukan
                
                doc.setDrawColor(0, 0, 0);
                finalY += 1;
  
                doc.line(40, finalY, 540, finalY);
                finalY += 1; 
                doc.line(40, finalY, 540, finalY);
                finalY += 8;
  
                
                // doc.text(`  Monthly : ${header.term} Month `, labelX, finalY + 20);
  
                // doc.text(`  Terbilang : ${totalBudgetTerbilang}`, labelX, finalY + 1);

                doc.setFont("helvetica", "bold"); // Set font menjadi bold
                doc.text('Terbilang :', labelX, finalY + 1); // Tetap rata kiri untuk label "Terbilang"

                doc.text(`${totalBudgetTerbilang}`, pageWidth - 90, finalY + 1, { align: 'right' }); // Rata kanan, 40pt dari sisi kanan halaman
                doc.setFont("helvetica", "normal"); // Kembali ke font normal jika diperlukan
                
                finalY += 8;
                doc.line(40, finalY, 540, finalY);
                finalY += 1; 
                doc.line(40, finalY, 540, finalY);
  
                finalY += 10; 


        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  
                // doc.setFontSize(6);
                
                // doc.text(`  ${pph23Text}`, labelX, finalY); 
                // finalY += 15;
                // const ppnTextWithPercent = `${ppnText} ${header.ppn_percent}%`;
                // doc.text(`  ${ppnTextWithPercent}`, labelX, finalY);
                
                // finalY += 15;
                // doc.text(`  Pekerjaan akan dilakukan oleh CS setelah ada pembayaran DP minimal 50% dari Brand.`, labelX, finalY);
                // finalY += 15;
                // doc.text(`  Bila disetujui, mohon approval dari quotation ini di email, dan dikirimkan kembali ke CS.`, labelX, finalY);
                // finalY += 15;
                // doc.text(`  PO/PP segera dikeluarkan langsung setelah quotation di approve.`, labelX, finalY);
  
                
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
              mythis.$root.apiHost + mythis.$root.prefixApi + "invoice";
            axios
              .post(
                url,
                {
                  invoice_number: mythis.todo.invoice_number, // Jika ada invoice number otomatis
                  trans_number: mythis.todo.trans_number,
                  due_date: mythis.todo.due_date,
                  total_invoice: mythis.todo.total_invoice,
                  created_by: mythis.userid,
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
        { name: "INVOICE NUMBER", width: "160px" },
        { name: "CUSTOMER", width: "150px" },
        { name: "ADDRESS", width: "150px" }, 
        { name: "KETERANGAN", width: "150px" },
        { name: "INVOICE DATE", width: "150px" },
        { name: "DUE DATE", width: "150px" }, 
        { name: "PROJECT", width: "150px" },
        { name: "PERSON IN CHARGE", width: "150px" }, 
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
                 <button data-id="${row.cells[0].data}" class="btn btn-sm btn-success text-white" id="exportInvoice" data-toggle="tooltip" title="Export Invoice" ><i class="fa fa-file-pdf-o"></i></button>`
              
                )
              : mythis.$root.accessRoles[mythis.access_page].update
              ? html(
                  
                `<button data-id="${row.cells[0].data}" class="btn btn-sm btn-warning text-white" id="editData" data-toggle="tooltip" title="Edit" ><i class="fa fa-pencil-square-o"></i></button>
               `
                )
              : mythis.$root.accessRoles[mythis.access_page].delete
              ? html(`&nbsp;&nbsp;&nbsp;
                <button data-id="${row.cells[0].data}" class="btn btn-sm btn-danger text-white" id="deleteData" data-toggle="tooltip" title="Delete" ><i class="fa fa-trash-o"></i></button>
               
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
            html(`<span class="pull-left">${card.invoi}</span>`),
            html(`<span class="pull-left">${card.customer}</span>`),
            html(`<span class="pull-left">${card.address}</span>`),
            html(`<span class="pull-left">${card.job}</span>`),
            html(`<span class="pull-left">${card.invoicedate}</span>`),
            html(`<span class="pull-left">${card.duedate}</span>`),
            html(`<span class="pull-left">${card.project}</span>`),
            html(`<span class="pull-left">${card.person_in_charge}</span>`),
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
        $(document).off("click", "#exportInvoice");
  
        $(document).on("click", "#exportInvoice", function () {
          let id = $(this).data("id");
          mythis.exportInvoice(id); // Pass the transaction ID to export PDF
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
     
    },
  };
  </script>
  
  <style scoped>
  .input-error {
    border: red 1px solid;
  }
  </style>
  