// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue'
import FastClick from 'fastclick'
import VueRouter from 'vue-router'
import App from './App'
import HelloWorld from './components/HelloWorld'
import HelloFromVux from './components/HelloFromVux'

import Icons from './components/Icons'
import XIcons from './components/XIcons'
import XButtons from './components/XButtons'
import FlexBoxes from './components/FlexBoxes'
import Grids from './components/Grids'
import Stickies from './components/Stickies'
import Calendars from './components/Calendars'
import CellBoxes from './components/CellBoxes'
import CellFormPreviews from './components/CellFormPreviews'
import Cells from './components/Cells'
import CheckIcons from './components/CheckIcons'
import Checkers from './components/Checkers'
import CheckLists from './components/CheckLists'
import DatetimeViews from './components/DatetimeViews'
import DatetimeRanges from './components/DatetimeRanges'
import Datetimes from './components/Datetimes'
import FormPreviews from './components/FormPreviews'
import Groups from './components/Groups'
import Switches from './components/Switches'
import Numbers from './components/Numbers'
import InlineCalendars from './components/InlineCalendars'
import PopupPickers from './components/PopupPickers'
import PopupRadios from './components/PopupRadios'
import Pickers from './components/Pickers'
import Raters from './components/Raters'
import Ranges from './components/Ranges'
import Selectors from './components/Selectors'
import Swipeouts from './components/Swipeouts'

//import router from './router' //使用index.js作为router，同时注释掉后面的const router=...


Vue.use(VueRouter)

//cnpm install vuex-i18n --save //demo中会用到
// import vuexI18n from 'vuex-i18n';
// const store = new Vuex.Store({
//   modules: {
//     i18n: vuexI18n.store
//   }
// });
// Vue.use(vuexI18n.plugin, store);

const routes = [{
  path: '/',
  name:'HelloFromVux',
  component: HelloFromVux
},{
  path:'/hello',
  name:'hello',
  component:HelloWorld
},{
  path:'/icons',
  component:Icons
},{
  path:'/xicons',
  component:XIcons
},{
  path:'/xbuttons',
  component:XButtons
},{
  path:'/flexboxes',
  component:FlexBoxes
},{
  path:'/grids',
  component:Grids
},{
  path:'/stickies',
  component:Stickies
},{
  path:'/calendars',
  component:Calendars
},{
  path:'/cellboxes',
  component:CellBoxes
},{
  path:'/cellformpreviews',
  component:CellFormPreviews
},{
  path:'/cells',
  component:Cells
},{
  path:'/checkicons',
  component:CheckIcons
},{
  path:'/checkers',
  component:Checkers
},{
  path:'/checklists',
  component:CheckLists
},{
  path:'/datetimeviews',
  component:DatetimeViews
},{
  path:'/datetimeranges',
  component:DatetimeRanges
},{
  path:'/datetimes',
  component:Datetimes
},{
  path:'/formpreviews',
  component:FormPreviews
},{
  path:'/groups',
  component:Groups
},{
  path:'/switches',
  component:Switches
},{
  path:'/numbers',
  component:Numbers
},{
  path:'/inlinecalendars',
  component:InlineCalendars
},{
  path:'/popuppickers',
  component:PopupPickers
},{
  path:'/popupradios',
  component:PopupRadios
},{
  path:'/pickers',
  component:Pickers
},{
  path:'/raters',
  component:Raters
},{
  path:'/ranges',
  component:Ranges
},{
  path:'/selectors',
  component:Selectors
},{
  path:'/swipeouts',
  component:Swipeouts
}]

const router = new VueRouter({
  routes
})

FastClick.attach(document.body)

Vue.config.productionTip = false

/* eslint-disable no-new */
new Vue({
  router,
  render: h => h(App)
}).$mount('#app-box')
