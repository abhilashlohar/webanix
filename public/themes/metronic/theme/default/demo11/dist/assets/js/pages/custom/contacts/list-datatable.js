"use strict";var KTUserListDatatable=function(){var t;return{init:function(){t=$("#kt_apps_user_list_datatable").KTDatatable({data:{type:"remote",source:{read:{url:"https://keenthemes.com/metronic/tools/preview/api/datatables/demos/client.php"}},pageSize:10,serverPaging:!0,serverFiltering:!0,serverSorting:!0},layout:{scroll:!1,footer:!1},sortable:!0,pagination:!0,search:{input:$("#generalSearch"),delay:400},columns:[{field:"ID",title:"#",sortable:!1,width:20,selector:{class:"kt-checkbox--solid"},textAlign:"center"},{field:"Name",title:"Name",width:200,template:function(t,e){for(var a=4+e;a>12;)a-=3;var n="100_"+a+".jpg",s=KTUtil.getRandomInt(0,5),l=["Developer","Designer","CEO","Manager","Architect","Sales"];return a>5?'<div class="kt-user-card-v2"><div class="kt-user-card-v2__pic"><img src="assets/media/users/'+n+'" alt="photo"></div><div class="kt-user-card-v2__details"><a href="#" class="kt-user-card-v2__name">'+t.Name+'</a><span class="kt-user-card-v2__desc">'+l[s]+"</span></div></div>":'<div class="kt-user-card-v2"><div class="kt-user-card-v2__pic"><div class="kt-badge kt-badge--xl kt-badge--'+["success","brand","danger","success","warning","primary","info"][KTUtil.getRandomInt(0,6)]+'">'+t.Name.substring(0,1)+'</div></div><div class="kt-user-card-v2__details"><a href="#" class="kt-user-card-v2__name">'+t.Name+'</a><span class="kt-user-card-v2__desc">'+l[s]+"</span></div></div>"}},{field:"City",title:"City"},{field:"Company",title:"Company",autoHide:!1,template:function(t,e){for(var a=e+1;a>5;)a-=3;return'<div class="kt-user-card-v2"><div class="kt-user-card-v2__pic"><img src="assets/media/client-logos/logo'+a+'.png" alt="photo"></div><div class="kt-user-card-v2__details"><a href="#" class="kt-user-card-v2__name">'+t.Company+'</a><span class="kt-user-card-v2__email">'+["Angular, React","Vue, Kendo",".NET, Oracle, MySQL","Node, SASS, Webpack","MangoDB, Java","HTML5, jQuery, CSS3"][a-1]+"</span></div></div>"}},{field:"Address",title:"Address",width:150,template:function(t){return t.Address1+" "+t.Address2}},{field:"Country",title:"Country"},{field:"DateCreated",title:"Date Created",type:"date",format:"MM/DD/YYYY"},{field:"DateModified",title:"Date Modified",type:"date",format:"MM/DD/YYYY"},{field:"Type",title:"Type",autoHide:!1,template:function(t){var e={1:{title:"Customer",class:" btn-label-brand"},2:{title:"Partner",class:" btn-label-danger"},3:{title:"Supplier",class:" btn-label-warning"},4:{title:"Staff",class:" btn-label-success"},5:{title:"Hot Lead",class:" btn-label-primary"},6:{title:"Cold Lead",class:" btn-label-info"}};return'<span class="btn btn-bold btn-sm btn-font-sm '+e[t.Type].class+'">'+e[t.Type].title+"</span>"}},{width:110,field:"Status",title:"Status",autoHide:!1,template:function(t){var e={1:{title:"Active",state:"success"},2:{title:"Pending",state:"primary"},3:{title:"Suspended",state:"danger"}};return'<span class="kt-badge kt-badge--'+e[t.Status].state+' kt-badge--dot"></span>&nbsp;<span class="kt-font-bold kt-font-'+e[t.Status].state+'">'+e[t.Status].title+"</span>"}},{field:"Actions",width:80,title:"Actions",sortable:!1,autoHide:!1,overflow:"visible",template:function(){return'<div class="dropdown"><a href="javascript:;" class="btn btn-sm btn-clean btn-icon btn-icon-md" data-toggle="dropdown"><i class="flaticon-more-1"></i></a><div class="dropdown-menu dropdown-menu-right"><ul class="kt-nav"><li class="kt-nav__item"><a href="#" class="kt-nav__link"><i class="kt-nav__link-icon flaticon2-expand"></i><span class="kt-nav__link-text">View</span></a></li><li class="kt-nav__item"><a href="#" class="kt-nav__link"><i class="kt-nav__link-icon flaticon2-contract"></i><span class="kt-nav__link-text">Edit</span></a></li><li class="kt-nav__item"><a href="#" class="kt-nav__link"><i class="kt-nav__link-icon flaticon2-trash"></i><span class="kt-nav__link-text">Delete</span></a></li><li class="kt-nav__item"><a href="#" class="kt-nav__link"><i class="kt-nav__link-icon flaticon2-mail-1"></i><span class="kt-nav__link-text">Export</span></a></li></ul></div></div>'}}]}),$("#kt_form_status").on("change",function(){t.search($(this).val().toLowerCase(),"Status")}),t.on("kt-datatable--on-check kt-datatable--on-uncheck kt-datatable--on-layout-updated",function(e){var a=t.rows(".kt-datatable__row--active").nodes().length;$("#kt_subheader_group_selected_rows").html(a),a>0?($("#kt_subheader_search").addClass("kt-hidden"),$("#kt_subheader_group_actions").removeClass("kt-hidden")):($("#kt_subheader_search").removeClass("kt-hidden"),$("#kt_subheader_group_actions").addClass("kt-hidden"))}),$("#kt_datatable_records_fetch_modal").on("show.bs.modal",function(e){var a=new KTDialog({type:"loader",placement:"top center",message:"Loading ..."});a.show(),setTimeout(function(){a.hide()},1e3);for(var n=t.rows(".kt-datatable__row--active").nodes().find('.kt-checkbox--single > [type="checkbox"]').map(function(t,e){return $(e).val()}),s=document.createDocumentFragment(),l=0;l<n.length;l++){var i=document.createElement("li");i.setAttribute("data-id",n[l]),i.innerHTML="Selected record ID: "+n[l],s.appendChild(i)}$(e.target).find("#kt_apps_user_fetch_records_selected").append(s)}).on("hide.bs.modal",function(t){$(t.target).find("#kt_apps_user_fetch_records_selected").empty()}),$("#kt_subheader_group_actions_status_change").on("click","[data-toggle='status-change']",function(){var e=$(this).find(".kt-nav__link-text").html(),a=t.rows(".kt-datatable__row--active").nodes().find('.kt-checkbox--single > [type="checkbox"]').map(function(t,e){return $(e).val()});a.length>0&&swal.fire({buttonsStyling:!1,html:"Are you sure to update "+a.length+" selected records status to "+e+" ?",type:"info",confirmButtonText:"Yes, update!",confirmButtonClass:"btn btn-sm btn-bold btn-brand",showCancelButton:!0,cancelButtonText:"No, cancel",cancelButtonClass:"btn btn-sm btn-bold btn-default"}).then(function(t){t.value?swal.fire({title:"Deleted!",text:"Your selected records statuses have been updated!",type:"success",buttonsStyling:!1,confirmButtonText:"OK",confirmButtonClass:"btn btn-sm btn-bold btn-brand"}):"cancel"===t.dismiss&&swal.fire({title:"Cancelled",text:"You selected records statuses have not been updated!",type:"error",buttonsStyling:!1,confirmButtonText:"OK",confirmButtonClass:"btn btn-sm btn-bold btn-brand"})})}),$("#kt_subheader_group_actions_delete_all").on("click",function(){var e=t.rows(".kt-datatable__row--active").nodes().find('.kt-checkbox--single > [type="checkbox"]').map(function(t,e){return $(e).val()});e.length>0&&swal.fire({buttonsStyling:!1,text:"Are you sure to delete "+e.length+" selected records ?",type:"danger",confirmButtonText:"Yes, delete!",confirmButtonClass:"btn btn-sm btn-bold btn-danger",showCancelButton:!0,cancelButtonText:"No, cancel",cancelButtonClass:"btn btn-sm btn-bold btn-brand"}).then(function(t){t.value?swal.fire({title:"Deleted!",text:"Your selected records have been deleted! :(",type:"success",buttonsStyling:!1,confirmButtonText:"OK",confirmButtonClass:"btn btn-sm btn-bold btn-brand"}):"cancel"===t.dismiss&&swal.fire({title:"Cancelled",text:"You selected records have not been deleted! :)",type:"error",buttonsStyling:!1,confirmButtonText:"OK",confirmButtonClass:"btn btn-sm btn-bold btn-brand"})})}),t.on("kt-datatable--on-layout-updated",function(){})}}}();KTUtil.ready(function(){KTUserListDatatable.init()});