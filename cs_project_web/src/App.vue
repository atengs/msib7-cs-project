<template>
  <LoadingX
    v-model:active="$root.isLoading"
    :can-cancel="false"
    :is-full-page="true"
    :z-index="100000"
    loader="bars"
  />
  <notifications position="bottom right" width="500" />
  <div id="page-wrapper" v-if="isLogin == 1">
    <div
      id="page-container"
      :class="
        $root.hide_menu_status
          ? 'sidebar-no-animations sidebar-visible-lg sidebar-visible-xs sidebar-visible-sm sidebar-visible-md'
          : 'sidebar-no-animations'
      "
    >
      <component :is="_header"></component>
      <div id="main-container">
        <component :is="_logout"></component>
        <div id="container">
          <component :is="activeRoute"></component>
          <component :is="_footer"></component>
        </div>
      </div>
    </div>
  </div>
  <div v-else>
    <!-- <component :is="_header" :params="params"></component> -->
    <component :is="activeRoute"></component>
  </div>
</template>

<script>
import { doc, getDoc, onSnapshot, updateDoc } from "firebase/firestore";
import db from "@/firebase/init.js";

import CryptoJS from "crypto-js";

import axios from "axios";

import { markRaw } from "vue";

import { defineAsyncComponent } from "vue";

// //jika belum ubah profil di sso
// import cmpHalProfilNotUpdate from "@/views/auth/_ProfilNotUpdate.vue";
// import cmpHalProfile from "@/views/pages/_profile.vue";

// import cmpHalForm from "@/views/pages/_form.vue";
// import cmpHalTable1 from "@/views/pages/_master1.vue";

// //master
// import cmpHalmUom from "@/views/pages/master/_mUom.vue";
// import cmpHalmType from "@/views/pages/master/_mType.vue";
// import cmpHalmTrCode from "@/views/pages/master/_mTrCode.vue";
// import cmpHalmWarehouse from "@/views/pages/master/_mWarehouse.vue";
// import cmpHalmCustomer from "@/views/pages/master/_mCustomer.vue";
// import cmpHalmProduct from "@/views/pages/master/_mProduct.vue";
// import cmpHalmBpItem from "@/views/pages/master/_mBpItem.vue";
// import cmpHalmCapacity from "@/views/pages/master/_mCapacity.vue";
// import cmpHalmRack from "@/views/pages/master/_mRack.vue";

// //log
// import cmpHalLogUsers from "@/views/pages/master/_logUsers.vue";

// //Transaction
// import cmpHalTrPutRequest from "@/views/pages/transaction/_trPutRequest.vue";
// import cmpHalSrLocate from "@/views/pages/transaction/_srLocate.vue";

const currentUrl = window.location.pathname;

import LoadingX from "vue3-loading-overlay";
import "vue3-loading-overlay/dist/vue3-loading-overlay.css";

import { Device } from "@capacitor/device";

// import { getMessaging, getToken, onMessage } from "firebase/messaging";

import _logout from "@/views/auth/_logout.vue";
import _header from "@/views/auth/_header.vue";
import _footer from "@/views/auth/_footer.vue";
import _Login from "@/views/auth/_Login.vue";

import cmpHalDashboard from "@/views/pages/cmpHalDashboard.vue";
import cmpHalProfile from "@/views/pages/cmpHalProfile.vue";
import cmpHalDashboard1 from "@/views/pages/cmpHalDashboard.vue";
import cmpHalDashboard2 from "@/views/pages/cmpHalDashboard.vue";
import cmpHalDashboard3 from "@/views/pages/cmpHalDashboard.vue";
import cmpMasterDocStatus from "@/views/pages/test/cmpMasterDocStatus.vue";
import cmpHalRoute from "@/views/pages/cmpHalRoute.vue";
import cmpMasterCategories from "./views/pages/master/cmpMasterCategories.vue";
import cmpMasterJobList from "./views/pages/master/cmpMasterJobList.vue";
import cmpTransaction from "./views/pages/master/cmpTransaction.vue";




//MENU DINAMIS GET DARI FOLDER - START
// const componentViews = import.meta.globEager("@/views/*.vue");
// const componentPages = import.meta.globEager("@/views/pages/**/*.vue");
// const componentAuth = import.meta.globEager("@/views/auth/*.vue");

// let routeComponent = {};
// Object.entries(componentViews).forEach((path, i) => {
//   let name = path[0].split("/").pop().replace(".vue", "");
//   routeComponent[name] = markRaw(path[1].default);
// });
// Object.entries(componentPages).forEach((path, i) => {
//   let name = path[0].split("/").pop().replace(".vue", "");
//   routeComponent[name] = markRaw(path[1].default);
// });
// Object.entries(componentAuth).forEach((path, i) => {
//   let name = path[0].split("/").pop().replace(".vue", "");
//   routeComponent[name] = markRaw(path[1].default);
// });
// //console.log("AAAAAAAAAAAAAA");
//console.log(routeComponent);
//MENU DINAMIS GET DARI FOLDER - END

const routeComponent = {
  cmpHalRoute: markRaw(cmpHalRoute),
  cmpHalDashboard: markRaw(cmpHalDashboard),
  cmpHalProfile: markRaw(cmpHalProfile),
  cmpHalDashboard1: markRaw(cmpHalDashboard1),
  cmpHalDashboard2: markRaw(cmpHalDashboard2),
  cmpHalDashboard3: markRaw(cmpHalDashboard3),
  cmpMasterDocStatus: markRaw(cmpMasterDocStatus),
  cmpMasterCategories: markRaw(cmpMasterCategories),
  cmpMasterJobList: markRaw(cmpMasterJobList),
  cmpTransaction: markRaw(cmpTransaction),
  Login: markRaw(_Login),
  _logout: markRaw(_logout),
  _header: markRaw(_header),
  _footer: markRaw(_footer),
};

// const routeComponent_Menu = {
//   // menu
//   cmpHalMaster: "MASTER",
//   cmpHalTransaction: "TRANSACTION",
//   cmpHalReport: "REPORT",

//   cmpHalKaryawan: "KARYAWAN",
//   cmpHalKehadiran: "KEHADIRAN",
//   cmpHalLiburNasional: "LIBUR NASIONAL",
//   cmpHalJadwalPerusahaan: "JADWAL PERUSAHAAN",
//   cmpHalJadwalKaryawan: "JADWAL KARYAWAN",
//   cmpHalPIC: "PIC",
//   cmpHalPerizinan: "PERIZINAN",

//   cmpHalItem: "ITEM",
//   cmpHalKartuStok: "KARTU STOK",
//   cmpHalMutasiStok: "MUTASI STOK",
//   cmpHalStockOpname: "STOCK OPNAME",
//   cmpHalCycleCount: "CYCLE COUNT",
//   cmpHalInbound: "INBOUND",
//   cmpHalOUtbound: "OUTBOUND",

//   cmpHalItemPrice: "ITEM PRICE",
//   cmpHalMasterMenuUser: "MENU LIST",

//   cmpHalDashboard: "Dashboard",
//   cmpHalForm: "Master Form",
//   cmpHalTable: "Master Table",
//   cmpHalProfile: "Master Profile",
//   cmpHalLogUsers: "Log Users",
//   cmpHalmUom: "Master Uom",
//   cmpHalmType: "Master Type",
//   cmpHalmTrCode: "Master Transaction Code",
//   cmpHalmWarehouse: "Master Warehouse",
//   cmpHalmCustomer: "Master Customer",
//   cmpHalmProduct: "Master Product",
//   cmpHalmBpItem: "Master BpItem",
//   cmpHalmCapacity: "Master Capacity",
//   cmpHalmRack: "Master Rack",
//   cmpHalTrPutRequest: "Transaction Put Request",
//   cmpHalSrLocate: "Rack Item Location",
// };

// const menuHeader_X = {
//   HRIS: {
//     // cmpHalMaster: {
//     //   cmpHalKaryawan: "KARYAWAN",
//     //   cmpHalLiburNasional: "LIBUR NASIONAL",
//     // },
//     cmpHalKehadiran: null,
//     cmpHalJadwalPerusahaan: null,
//     cmpHalJadwalKaryawan: null,
//     cmpHalPIC: null,
//     cmpHalPerizinan: null,
//   },

//   WMS: {
//     cmpHalMaster: {
//       cmpHalItem: null,
//       cmpHalItemPrice: null,
//     },
//     cmpHalTransaction: {
//       cmpHalInbound: null,
//       cmpHalOUtbound: null,
//     },
//     cmpHalReport: {
//       cmpHalKartuStok: null,
//       cmpHalMutasiStok: null,
//     },
//     cmpHalStockOpname: null,
//     cmpHalCycleCount: null,
//   },

//   SALES: {
//     cmpHalMaster: {
//       cmpHalItemPrice: null,
//     },
//     cmpHalReport: {
//       cmpHalSales: null,
//     },
//   },
//   MASTER: {
//     cmpHalMasterMenuUser: null,
//   },
//   // Master: {
//   //   //cmpHalForm: "cmpHalForm",
//   //   cmpHalTable: "cmpHalTable",
//   //   cmpHalmUom: "cmpHalmUom",
//   //   cmpHalmType: "cmpHalmType",
//   //   cmpHalmTrCode: "cmpHalmTrCode",
//   //   cmpHalmWarehouse: "cmpHalmWarehouse",
//   //   cmpHalmCustomer: "cmpHalmCustomer",
//   //   cmpHalmProduct: "cmpHalmProduct",
//   //   cmpHalmBpItem: "cmpHalmBpItem",
//   //   cmpHalmCapacity: "cmpHalmCapacity",
//   //   cmpHalmRack: "cmpHalmRack",
//   // },
//   // Transaction: {
//   //   cmpHalTrPutRequest: "cmpHalTrPutRequest",
//   //   cmpHalSrLocate: "cmpHalSrLocate",
//   // },
//   // Log: {
//   //   cmpHalLogUsers: "cmpHalLogUsers",
//   // },
// };

// const routeComponent_Menu = {
//   cmpHalUser: "USER",
//   cmpHalUserRoles: "USER ROLES",
//   cmpHalUserAccess: "USER ACCESS",
//   cmpHalMenuListGroup: "MENU LIST GROUP",
//   cmpHalMenuList: "MENU LIST",
// };
// const menuHeader_X = {
//   SETTING: {
//     cmpHalUser: null,
//     cmpHalUserRoles: null,
//     cmpHalUserAccess: null,
//     cmpHalMenuListGroup: null,
//     cmpHalMenuList: null,
//   },
// };

// const menuHeader_X_logo = {
//   // menu
//   WMSx: "gi gi-shopping_cart sidebar-nav-icon",
//   SALESx: "gi gi-money sidebar-nav-icon",
//   MASTERx: "gi gi-settings sidebar-nav-icon",
//   HRISx: "gi gi-group sidebar-nav-icon",
//   TRANSACTIONx: "gi gi-transfer sidebar-nav-icon",
//   VOIPx: "gi gi-phone_alt sidebar-nav-icon",
// };

export default {
  components: { LoadingX },
  data() {
    const apiHost = import.meta.env.VITE_API_HOST,
      apiHostJWT = import.meta.env.VITE_API_HOST_JWT,
      appHost = import.meta.env.VITE_APP_HOST,
      appID = import.meta.env.VITE_APP_ID,
      appBaseUrl = import.meta.env.VITE_APP_BASE_URL,
      appSsoUrl = import.meta.env.VITE_APP_SSO_URL,
      appSsoTokenStatus = import.meta.env.VITE_APP_SSO_TOKEN_STATUS,
      pagingTabel1 = import.meta.env.VITE_APP_PAGING_TABEL1,
      timerLoginDetik = import.meta.env.VITE_APP_TIMER_LOGIN_DETIK,
      secretCodeEnc = import.meta.env.VITE_APP_SECRET_CODE_ENC,
      appName = import.meta.env.VITE_APP_NAMA_APLIKASI,
      prefixApi = import.meta.env.VITE_APP_PREFIX_API,
      // menuHeader_logo = menuHeader_X_logo,
      // menuUserHtml = routeComponent_Menu,
      // menuHeader = menuHeader_X,
      apiHostEXPRESS_1 = import.meta.env.VITE_APP_BASE_URL_EXPRESS_VUE_1,
      apiHostAttendance = import.meta.env.VITE_API_HOST_ATTENDANCE,
      apiTokenFCM = import.meta.env.VITE_APP_FCM_WEB_PUSH_CERTIFICATE,
      apiTokenWA = import.meta.env.VITE_APP_FONNTE_TOKEN,
      apiFCMStatus = import.meta.env.VITE_APP_FCM_STATUS,
      menuUser = routeComponent;

    return {
      apiFCMStatus: apiFCMStatus,
      apiTokenFCM: apiTokenFCM,
      apiTokenWA: apiTokenWA,
      apiHostAttendance: apiHostAttendance,
      apiHostEXPRESS_1: apiHostEXPRESS_1,
      isLoading: false,
      halamanSekarang: localStorage.getItem("halaman"),
      userName:
        localStorage.getItem("userName") != "null"
          ? localStorage.getItem("userName")
          : "Selamat Datang.",
      appName: appName,
      apiHost: apiHost,
      appHost: appHost,
      prefixApi : prefixApi,
      appID: appID,
      apiHostJWT: apiHostJWT,
      appBaseUrl: appBaseUrl,
      appSsoUrl: appSsoUrl,
      appSsoTokenStatus: appSsoTokenStatus,

      menuUser: menuUser,
      // menuHeader_logo: menuHeader_logo,
      timerLoginDetik: timerLoginDetik,
      isLogin: localStorage.getItem("token") != null ? 1 : 0,
      activeRoute: null,
      // headerLayout: markRaw(headerLayout),
      // logoutLayout: markRaw(cmpHalLogout),
      _header: routeComponent["_header"],
      _logout: routeComponent["_logout"],
      _footer: routeComponent["_footer"],
      params: null,
      cmpMenu: null,
      pagingTabel1: pagingTabel1,
      secretCodeEnc: secretCodeEnc,

      docFirebase: doc,
      getDocFirebase: getDoc,
      onSnapshotFirebase: onSnapshot,
      updateDocFirebase: updateDoc,
      dbFirebase: db,

      users: {
        doc1: "doc1",
      },

      flagFirebaseNotif: false,
      flagButtonLoading: false,

      // menuHeader: menuHeader,
      // menuUserHtml: menuUserHtml,
      // menuHeader: null,
      // menuUserHtml: {},
      // menuHeader_status: null,

      menuHeader: {
        "NAMA MENU": {
          MASTER: {
            cmpMasterDocStatus: "MENU TEST 1",
            cmpMasterCategories: "MASTER CATEGORY",
            cmpMasterJobList: "MASTER JOB LIST",
            cmpTransaction: "TRANSACTION",
            "SUB MENU": {
              cmpHalDashboard1: "DASHBOARD1",
              cmpHalDashboard2: "DASHBOARD2",
              cmpHalDashboard3: "DASHBOARD3",
            },
          },
        },
      },
      menuUserHtml: {
        cmpMasterDocStatus: "MENU TEST 1",
        cmpMasterCategories: "MASTER CATEGORY",
        cmpMasterJobList: "MASTER JOB LIST",
        cmpTransaction: "TRANSACTION",
        cmpHalDashboard1: "DASHBOARD1",
        cmpHalDashboard2: "DASHBOARD2",
        cmpHalDashboard3: "DASHBOARD3",
      },
      menuHeader_status: {
        MASTER: false,
        "NAMA MENU": false,
        "SUB MENU": false,
      },

      // accessRoles: {},
      accessRoles: {
        cmpMasterDocStatus: {
          create: true,
          update: true,
          delete: true,
        },
        cmpMasterCategories: {
          create: true,
          update: true,
          delete: true,
        },
        cmpMasterJobList: {
          create: true,
          update: true,
          delete: true,
        },
        cmpTransaction: {
          create: true,
          update: true,
          delete: true,
        },
      },

      profile_status: false,
      hide_menu_status: true,

      judulHalaman: "",
      ref: "",

      device_info: "",
      userid: 0,

      token_firebase: "",

      notifikasi_total: 0,
      notifikasi_detail: {},
    };
  },
  async created() {
    // this.getNotifFirebase();
    // Notification.requestPermission()
    //   .then((permission) => {
    //     console.log(`Permission: ${permission}`);
    //     if (permission == "granted") {
    //       if (this.apiFCMStatus == 1) {
    //         this.setup_FCM();
    //       }
    //     }
    //   })
    //   .catch((error) => {
    //     console.error(`Error: ${error}`);
    //   });
    // let uObject = localStorage.getItem("uObject");
    // if (uObject != null) {
    //   await this.getMenu();
    // }
  },
  async mounted() {
    this.activePage();
    document.getElementById("BG_flag").remove();
    document.head.innerHTML +=
      '<link href="/src/assets/css/themes/' +
      localStorage.getItem("themes") +
      '" rel="stylesheet" id="BG_flag"/>';
  },
  methods: {
    async changeColorBG(themes) {
      this.$root.presentLoading();

      document.getElementById("BG_flag").innerHTML =
        '<link href="/src/assets/css/themes/' +
        themes +
        '" rel="stylesheet" id="BG_flag"/>';

      // document.getElementById("BG_flag").remove();
      // document.head.innerHTML +=
      //   '<link href="/src/assets/css/themes/' +
      //   themes +
      //   '" rel="stylesheet" id="BG_flag"/>';

      // await this.$root.sleep(1000);
      localStorage.setItem("themes", themes);
      this.$root.stopLoading();
    },
    async sleep(ms) {
      return new Promise((resolve) => setTimeout(resolve, ms));
    },
    get_id_user(unique) {
      if (unique == null || unique == undefined) {
        return;
      }
      var idx = this.$root.decryptData(unique);
      const myArray = idx.split("ABCDEFG");
      let word = myArray[1];
      return word;
    },
    hide_menu_status_open() {
      this.hide_menu_status = !this.hide_menu_status;
    },
    status_profil_open() {
      this.profile_status = !this.profile_status;
    },
    status_menu_open(header_menu) {
      this.menuHeader_status[header_menu] =
        !this.menuHeader_status[header_menu];
    },
    async sendNotifFirebase(header, body) {
      //return false;

      var mythis = this;
      //console.log("update");
      const fireBaseTime = new Date();
      Object.keys(mythis.$root.users).forEach(async function (key) {
        await mythis.$root.updateDocFirebase(
          mythis.$root.docFirebase(
            mythis.$root.dbFirebase,
            "users",
            mythis.$root.users[key]
          ),
          {
            header_pesan: header,
            body_pesan: body,
            update_at_pesan: fireBaseTime,
          }
        );
      });
    },
    async getNotifFirebase() {
      // register realtime listener
      // for changes on 'GB' document
      onSnapshot(doc(db, "users", "doc1"), (snap) => {
        if (this.flagFirebaseNotif == false) {
          this.flagFirebaseNotif = true;
          return false;
        }

        //console.log(snap.data());
        this.header_pesan = snap.data().header_pesan;
        this.body_pesan = snap.data().body_pesan;
        this.update_at_pesan = snap.data().update_at_pesan;

        if (this.header_pesan == "notif_in_apps") {
          let uObject = JSON.parse(localStorage.getItem("uObject"));
          this.getNotifDetail(uObject.userEmail);
        } else {
          // this.$notify({
          //   title: this.header_pesan,
          //   text: this.body_pesan,
          //   closeOnClick: true,
          //   pauseOnHover: true,
          //   duration: 1800000,
          // });
        }
      });
    },
    goto: function (comp, p) {
      var that = this;

      that.judulHalaman = "";

      that.$root.profile_status = false;
      if (typeof p != "undefined") {
        this.params = p;
      }
      //localStorage.setItem("halaman", comp);
      localStorage.setItem("halaman", this.encryptData(comp));
      if (comp != "cmpHalDashboard") {
        sessionStorage.removeItem("first");
      }

      const tokenx = localStorage.getItem("token");
      that.cmpMenu = comp;
      that.activeRoute = that.menuUser[comp];
      that.halamanSekarang = that.cmpMenu;
    },
    async presentLoading() {
      this.isLoading = true;
    },
    async stopLoading() {
      this.isLoading = false;
    },
    activePage: function () {
      console.log(this.decryptData(localStorage.getItem("halaman")));
      let tmpactiveRoute =
        localStorage.getItem("token") != null
          ? localStorage.getItem("halaman") == null ||
            localStorage.getItem("halaman") == "" ||
            localStorage.getItem("halaman") == undefined
            ? this.menuUser["cmpHalDashboard"]
            : this.menuUser[this.decryptData(localStorage.getItem("halaman"))]
          : this.menuUser["cmpHalRoute"];

      this.activeRoute = tmpactiveRoute;
    },
    encryptData(x) {
      // hash the name with any algorithm
      const data = CryptoJS.AES.encrypt(x, this.secretCodeEnc).toString();
      return data;
    },

    decryptData(y) {
      // decrypt the data and convert to string
      if (y == undefined) return false;
      const data = CryptoJS.AES.decrypt(y, this.secretCodeEnc).toString(
        CryptoJS.enc.Utf8
      );
      return data;
    },
  },
};
</script>
