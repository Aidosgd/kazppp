webpackJsonp([0],{"3Jzc":function(t,a,e){e("qz1W");var s=e("VU/8")(e("kOaX"),e("tXnL"),"data-v-2f850503",null);t.exports=s.exports},"3i4i":function(t,a,e){a=t.exports=e("FZ+f")(),a.push([t.i,".col-md-4[data-v-2f850503]{text-align:center;padding:0 50px}img[data-v-2f850503]{width:100%}.users-list[data-v-2f850503]{padding:0}.users-list li[data-v-2f850503]{list-style:none;background:#ddd;border-bottom:1px solid;padding:8px 0}.users-list li[data-v-2f850503]:nth-of-type(odd){background:#fff}",""])},kOaX:function(t,a,e){"use strict";Object.defineProperty(a,"__esModule",{value:!0}),a.default={data:function(){return{contacts:[]}},computed:{backendData:function(){return this.state.backend_data[this.$route.name].data}},backend_created:function(t,a,e){return a.state.ServerXHR.open("get","/backend/home/allContacts").then(function(e){a.state.backend_data[t.currentRoute.name]=JSON.parse(e.responseText)})},methods:{fetchComponentData:function(){var t=this;this.$store.commit("changeStoreRequestIsBeingSent",!0),axios.get("/backend/home/allContacts").then(function(a){t.contacts=a.data.data.contacts,t.$store.commit("changeStoreRequestIsBeingSent",!1)})},fetchBackendData:function(){var t=this;this.$store.commit("changeStoreRequestIsBeingSent",!0),axios.get("/backend/home/twoContacts").then(function(a){t.change_backend_data({route_name:t.$route.name,backend_data:a.data}),t.$store.commit("changeStoreRequestIsBeingSent",!1)})}}}},qz1W:function(t,a,e){var s=e("3i4i");"string"==typeof s&&(s=[[t.i,s,""]]),s.locals&&(t.exports=s.locals);e("rjj0")("4181e395",s,!0)},tXnL:function(t,a){t.exports={render:function(){var t=this,a=t.$createElement,e=t._self._c||a;return e("div",{staticClass:"container"},[e("h1",{staticClass:"text-center"},[t._v("StarterKit IBEC Systems")]),t._v(" "),t._m(0),t._v(" "),e("hr"),t._v(" "),e("h1",[t._v(t._s(t.trans("common.an_example_of_a_vue_router")))]),t._v(" "),e("ul",t._l(t.Laravel.supportedLocales,function(a,s){return e("li",[e("a",{attrs:{href:"/"+s}},[t._v(t._s(a.name))])])})),t._v(" "),e("div",{staticClass:"row"},[e("div",{staticClass:"col-md-3"},[e("ul",[e("li",[e("router-link",{attrs:{to:t.Laravel.getLocalizedRoute({name:"home"})}},[t._v("Главная")])],1),t._v(" "),e("li",[e("router-link",{attrs:{to:t.Laravel.getLocalizedRoute({name:"contact"})}},[t._v("Контакты")])],1)])]),t._v(" "),e("div",{staticClass:"col-md-9"},[e("router-view")],1)]),t._v(" "),e("hr"),t._v(" "),e("h1",[t._v("Примеры запросов к API c сервера")]),t._v(" "),e("div",{staticClass:"row"},[e("div",{staticClass:"col-md-3"},[e("button",{staticClass:"btn btn-default",on:{click:t.fetchBackendData}},[t._v("Перезаписать")])]),t._v(" "),e("div",{staticClass:"col-md-9"},[e("h3",[t._v("Результаты")]),t._v(" "),e("ul",{staticClass:"users-list"},t._l(t.backendData.contacts,function(a){return e("li",[t._v("\n                    id: "+t._s(a.id)+" - name: "+t._s(a.name)+"\n                ")])}))])]),t._v(" "),e("hr"),t._v(" "),e("h1",[t._v("Примеры запросов к API")]),t._v(" "),e("div",{staticClass:"row"},[e("div",{staticClass:"col-md-3"},[e("button",{staticClass:"btn btn-default",on:{click:t.fetchComponentData}},[t._v("Получить пользователей")])]),t._v(" "),e("div",{staticClass:"col-md-9"},[e("h3",[t._v("Результаты")]),t._v(" "),e("ul",{staticClass:"users-list"},t._l(t.contacts,function(a){return e("li",[t._v("\n                    id: "+t._s(a.id)+" - name: "+t._s(a.name)+"\n                ")])}))])])])},staticRenderFns:[function(){var t=this,a=t.$createElement,e=t._self._c||a;return e("div",{staticClass:"row"},[e("div",{staticClass:"col-md-4"},[e("a",{attrs:{target:"_blank",href:"http://ibecsystems.com/ru#/"}},[e("img",{staticClass:"img-responsive",staticStyle:{"margin-top":"20px"},attrs:{src:"/images/logo/ibec-systems.svg",alt:""}})])]),t._v(" "),e("div",{staticClass:"col-md-4"},[e("a",{attrs:{target:"_blank",href:"https://laravel.com/"}},[e("img",{staticClass:"img-responsive",attrs:{src:"/images/logo/Laravel_logo.png",alt:""}})])]),t._v(" "),e("div",{staticClass:"col-md-4"},[e("a",{attrs:{target:"_blank",href:"https://vuejs.org/"}},[e("img",{staticClass:"img-responsive",attrs:{src:"/images/logo/Vue-logo.svg",alt:""}})])])])}]}}});