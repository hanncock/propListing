
   

var url = 'http://192.168.1.117:3000';
// var url = 'https://5922-196-202-189-11.ngrok-free.app';

/*

location
type of prop i.e sale or rent or diaspora
add  whatsapp endpoint

*/


var properties;

var xmlhttp = new XMLHttpRequest();


//Login Page
function Login(){
  
  let json = JSON.stringify({
      email: document.getElementById("username").value,
      pass: document.getElementById("password").value
  });

  xmlhttp.onload = function() {

      const myObj = JSON.parse(this.responseText);
  
      console.log(myObj['success']);

      if(myObj['success'] == true){
          console.log('login');
        //   alert(url+"/dashboard.html");
          window.location.replace(url+"/etenev-web_final/dev/dashboard.html");
      }else{
        alert('wrong username or password');
      }
  
  }
  
  xmlhttp.open("POST", url+"/api/users/login", true);
  xmlhttp.send(json);

}


var imgsrc ;
//Dahsboard
function readFile() {
    let file =document.querySelector('input[type=file]')['files'][0];
//   let file = input.files[0]; 
  let fileReader = new FileReader(); 
  fileReader.readAsDataURL(file); 
  fileReader.onload = function() {
      // document.getElementById("result").innerText = fileReader.result
  console.log(fileReader.result);

    //   document.getElementById("base64").value = fileReader.result
     imgsrc = fileReader.result
    //   document.getElementById("base64").innerHTML = fileReader.result
  }; 
  fileReader.onerror = function() {
      alert(fileReader.error);
  }; 

}



function SaveProp(){
  let json = JSON.stringify({
      propName: document.getElementById('propName').value,
      propType : document.getElementById('propType').value,
      listType : document.getElementById('listingType').value,
      propDescription: document.getElementById('propDescription').value,
      propContact : document.getElementById('propContact').value,
      propPrice : document.getElementById('propPrice').value,
      propSize : document.getElementById('propSize').value,
      propLeaseType : document.getElementById('propLeaseType').value, 
      propMonthlyPay: document.getElementById('propMonthlyPay').value,
      propStatus : document.getElementById('propStatus').value,
      propUnits : document.getElementById('propUnits').value,
      propStatus : document.getElementById('propStatus').value,
      propAvailableUnits : document.getElementById('propAvailableUnits').value,
      propBeds : document.getElementById('propBeds').value,
      propBaths : document.getElementById('propBaths').value,
      propSqrfoot : document.getElementById('propSqrfoot').value,
      image : document.getElementById('base64').value,
      image : imgsrc,
     
  });

  console.log(json);

  xmlhttp.onload = function() {

      const myObj = JSON.parse(this.responseText);
  
      console.log(myObj['data']);

      if(myObj['data'] == 'success'){
          // console.log('login');
          window.location.replace(url+"etenev-web_final/dev/dashboard.html");
      }
  
  }
  
  xmlhttp.open("POST", url+"/api/properties/add", true);
  xmlhttp.send(json);
  return false;
}


function propListing(){


    xmlhttp.onload = function() {

        const myObj = JSON.parse(this.responseText);
    
        console.log(myObj['data']);

        for(var key in myObj['data']) {
            document.getElementById('listdisps').innerHTML += 
    '<div class="group rounded-xl bg-white dark:bg-slate-900 shadow hover:shadow-xl dark:hover:shadow-xl dark:shadow-gray-700 dark:hover:shadow-gray-700 overflow-hidden ease-in-out duration-500 w-full mx-auto lg:max-w-2xl">'+
                        '<div class="md:flex">'+
                            '<div class="relative md:shrink-0">'+
                                '<img class="h-full w-full object-cover md:w-48" src="'+url+'/'+myObj['data'][key]['image']+'" alt="">'+
                                '<div class="absolute top-4 ltr:right-4 rtl:left-4">'+
                                    '<a href="javascript:void(0)" class="btn btn-icon bg-white dark:bg-slate-900 shadow dark:shadow-gray-700 rounded-full text-slate-100 dark:text-slate-700 focus:text-red-600 dark:focus:text-red-600 hover:text-red-600 dark:hover:text-red-600"><i class="mdi mdi-heart mdi-18px"></i></a>'+
                                '</div>'+
                            '</div>'+
                            '<div class="p-6">'+
                                '<div class="md:pb-4 pb-6">'+
                                    '<a href="property-detail.html?'+ myObj['data'][key]['propId'] +'" class="text-lg hover:text-green-600 font-medium ease-in-out duration-500">'+  myObj['data'][key]['propName'] +'</a>'+
                                '</div>'+

                                '<ul class="md:py-4 py-6 border-y border-slate-100 dark:border-gray-800 flex items-center list-none">'+
                                    '<li class="flex items-center ltr:mr-4 rtl:ml-4">'+
                                       ' <i class="uil uil-compress-arrows text-2xl ltr:mr-2 rtl:ml-2 text-green-600"></i>'+
                                        '<span>'+myObj['data'][key]['propSqrfoot']+'sqf</span>'+
                                    '</li>'+

                                    '<li class="flex items-center ltr:mr-4 rtl:ml-4">'+
                                        '<i class="uil uil-bed-double text-2xl ltr:mr-2 rtl:ml-2 text-green-600"></i>'+
                                       '<span>'+myObj['data'][key]['propBeds']+'Beds</span>'+
                                    '</li>'+

                                    '<li class="flex items-center">'+
                                        '<i class="uil uil-bath text-2xl ltr:mr-2 rtl:ml-2 text-green-600"></i>'+
                                        '<span>'+myObj['data'][key]['propBaths']+'Baths</span>'+
                                    '</li>'+
                               ' </ul>'+

                                '<ul class="md:pt-4 pt-6 flex justify-between items-center list-none">'+
                                    '<li>'+
                                        '<span class="text-slate-400">Price</span>'+
                                        '<p class="text-lg font-medium">'+myObj['data'][key]['propPrice']+'</p>'+
                                    '</li>'+

                                    '<li>'+
                                        '<span class="text-slate-400">Rating</span>'
                                        '<ul class="text-lg font-medium text-amber-400 list-none">'+
                                            '<li class="inline"><i class="mdi mdi-star"></i></li>'+
                                            '<li class="inline"><i class="mdi mdi-star"></i></li>'+
                                            '<li class="inline"><i class="mdi mdi-star"></i></li>'+
                                            '<li class="inline"><i class="mdi mdi-star"></i></li>'+
                                            '<li class="inline"><i class="mdi mdi-star"></i></li>'+
                                            '<li class="inline text-black dark:text-white">5.0(30)</li>'+
                                        '</ul>'+
                                    '</li>'+
                                '</ul>'+
                           ' </div>'+
                        '</div>'+
                    '</div>';

        }

    }
    xmlhttp.open("GET", url+"/api/properties/list", true);
    // xmlhttp.setRequestHeader ("Accept", "text/xml");
    xmlhttp.setRequestHeader('Access-Control-Allow-Origin','*');
    xmlhttp.setRequestHeader('Content-type','application/json');
    xmlhttp.send();
}


function getProperties(){

    var xmlhttp = new XMLHttpRequest();

    console.log('getting properties');
    // console.log('all fetch');

    xmlhttp.onload = function() {

        const myObj = JSON.parse(this.responseText);
    
        console.log(myObj['data']);

        for(var key in myObj['data']) {
            console.log(url+'/'+myObj['data'][key]['image']);

            document.getElementById('alldisps').innerHTML += 

            '<div class="group rounded-xl bg-white dark:bg-slate-900 shadow hover:shadow-xl dark:hover:shadow-xl dark:shadow-gray-700 dark:hover:shadow-gray-700 overflow-hidden ease-in-out duration-500"> '+
            '<div class="relative">'+
// '<img src="assets/images/property/1.jpg" alt="">'+
'<img src="'+url+'/'+myObj['data'][key]['image']+'" alt="">'+

                '<div class="absolute top-4 ltr:right-4 rtl:left-4">'+
                    '<a href="javascript:void(0)" class="btn btn-icon bg-white dark:bg-slate-900 shadow dark:shadow-gray-700 rounded-full text-slate-100 dark:text-slate-700 focus:text-red-600 dark:focus:text-red-600 hover:text-red-600 dark:hover:text-red-600"><i class="mdi mdi-heart mdi-18px"></i></a>'+
                '</div>'+
            '</div>'+

            '<div class="p-6">'+
                '<div class="pb-6">'+
                    '<a href="property-detail.html?'+ myObj['data'][key]['propId'] +'" class="text-lg hover:text-green-600 font-medium ease-in-out duration-500">'+  myObj['data'][key]['propName'] +'</a>'+
                '</div>'+

                '<ul class="py-6 border-y border-slate-100 dark:border-gray-800 flex items-center list-none">'+
                    '<li class="flex items-center ltr:mr-4 rtl:ml-4">'+
                        '<i class="uil uil-compress-arrows text-2xl ltr:mr-2 rtl:ml-2 text-green-600"></i>'+
                        '<span >'+myObj['data'][key]['propSqrfoot']+' Sqf</span>'+
                    '</li>'+

                    '<li class="flex items-center ltr:mr-4 rtl:ml-4">'+
                        '<i class="uil uil-bed-double text-2xl ltr:mr-2 rtl:ml-2 text-green-600"></i>'+
                        '<span >'+myObj['data'][key]['propBeds']+' Beds</span>'+
                    '</li>'+

                    '<li class="flex items-center">'+
                        '<i class="uil uil-bath text-2xl ltr:mr-2 rtl:ml-2 text-green-600"></i>'+
                        '<span >'+myObj['data'][key]['propBaths']+' Baths</span>'+
                    '</li>'+
                '</ul>'+

                '<ul class="pt-6 flex justify-between items-center list-none">'+
                   ' <li>'+
                        '<span class="text-slate-400">Price</span>'+
                        '<p class="text-lg font-medium" >Ksh '+myObj['data'][key]['propPrice']+'</p>'+
                    '</li>'+

                    '<li>'+
                        '<span class="text-slate-400">Rating</span>'+
                        '<ul class="text-lg font-medium text-amber-400 list-none">'+
                            '<li class="inline"><i class="mdi mdi-star"></i></li>'+
                            '<li class="inline"><i class="mdi mdi-star"></i></li>'+
                            '<li class="inline"><i class="mdi mdi-star"></i></li>'+
                            '<li class="inline"><i class="mdi mdi-star"></i></li>'+
                            '<li class="inline"><i class="mdi mdi-star"></i></li>'+
                            '<li class="inline text-black dark:text-white">5.0(30)</li>'+
                        '</ul>'+
                    '</li>'+
                '</ul>'+
            '</div>'+
        '</div>'
         }
         
    }
    
    xmlhttp.open("GET", url+"/api/properties/list", true);
    // xmlhttp.setRequestHeader ("Accept", "text/xml");
    xmlhttp.setRequestHeader('Access-Control-Allow-Origin','*');
    xmlhttp.setRequestHeader('Content-type','application/json');
    xmlhttp.send();
}

function getPropertiesDel(){

    var xmlhttp = new XMLHttpRequest();

    console.log('getting properties');
    // console.log('all fetch');

    xmlhttp.onload = function() {

        const myObj = JSON.parse(this.responseText);
    
        console.log(myObj['data']);

        for(var key in myObj['data']) {
            console.log(url+'/'+myObj['data'][key]['image']);

            document.getElementById('alldispsadmin').innerHTML += 

            '<div class="group rounded-xl bg-white dark:bg-slate-900 shadow hover:shadow-xl dark:hover:shadow-xl dark:shadow-gray-700 dark:hover:shadow-gray-700 overflow-hidden ease-in-out duration-500"> '+
            '<div class="relative">'+
// '<img src="assets/images/property/1.jpg" alt="">'+
'<img src="'+url+'/'+myObj['data'][key]['image']+'" alt="">'+

                '<div class="absolute top-4 ltr:right-4 rtl:left-4">'+
                    '<a href="javascript:void(0)" class="btn btn-icon bg-white dark:bg-slate-900 shadow dark:shadow-gray-700 rounded-full text-slate-100 dark:text-slate-700 focus:text-red-600 dark:focus:text-red-600 hover:text-red-600 dark:hover:text-red-600"><i class="mdi mdi-heart mdi-18px"></i></a>'+
                '</div>'+
            '</div>'+

            '<div class="p-6">'+
                '<div class="pb-6">'+
                    '<a href="property-detail.html?'+ myObj['data'][key]['propId'] +'" class="text-lg hover:text-green-600 font-medium ease-in-out duration-500">'+  myObj['data'][key]['propName'] +'</a>'+
                '</div>'+

                '<ul class="py-6 border-y border-slate-100 dark:border-gray-800 flex items-center list-none">'+
                    '<li class="flex items-center ltr:mr-4 rtl:ml-4">'+
                        '<i class="uil uil-compress-arrows text-2xl ltr:mr-2 rtl:ml-2 text-green-600"></i>'+
                        '<span >'+myObj['data'][key]['propSqrfoot']+' Sqf</span>'+
                    '</li>'+

                    '<li class="flex items-center ltr:mr-4 rtl:ml-4">'+
                        '<i class="uil uil-bed-double text-2xl ltr:mr-2 rtl:ml-2 text-green-600"></i>'+
                        '<span >'+myObj['data'][key]['propBeds']+' Beds</span>'+
                    '</li>'+

                    '<li class="flex items-center">'+
                        '<i class="uil uil-bath text-2xl ltr:mr-2 rtl:ml-2 text-green-600"></i>'+
                        '<span >'+myObj['data'][key]['propBaths']+' Baths</span>'+
                    '</li>'+
                '</ul>'+

                '<ul class="pt-6 flex justify-between items-center list-none">'+
                   ' <li>'+
                        '<span class="text-slate-400">Price</span>'+
                        '<p class="text-lg font-medium" >Ksh '+myObj['data'][key]['propPrice']+'</p>'+
                    '</li>'+

                    '<li>'+
                        '<span class="text-slate-400">Rating</span>'+
                        '<ul class="text-lg font-medium text-amber-400 list-none">'+
                            '<li class="inline"><i class="mdi mdi-star"></i></li>'+
                            '<li class="inline"><i class="mdi mdi-star"></i></li>'+
                            '<li class="inline"><i class="mdi mdi-star"></i></li>'+
                            '<li class="inline"><i class="mdi mdi-star"></i></li>'+
                            '<li class="inline"><i class="mdi mdi-star"></i></li>'+
                            '<li class="inline text-black dark:text-white">5.0(30)</li>'+
                        '</ul>'+
                    '</li>'+
                '</ul>'+
            '</div>'+
            '<li class="sm:inline ltr:pl-1 rtl:pr-1 mb-0 hidden">'+
                '<a onclick="del('+ myObj['data'][key]['propId']+')" class="btn bg-green-600 hover:bg-red-700 border-green-600 dark:border-green-600 text-white rounded-full">Del</a>'+
            '</li>'+
            '<li class="sm:inline ltr:pl-1 rtl:pr-1 mb-0 hidden">'+
                '<a href="dashboard.html" onclick='+setDetaisl()+' class="btn bg-green-600 hover:bg-red-700 border-green-600 dark:border-green-600 text-white rounded-full">Edit</a>'+
            ' </li>'+
        '</div>'
         }
         
    }
    
    xmlhttp.open("GET", url+"/api/properties/list", true);
    // xmlhttp.setRequestHeader ("Accept", "text/xml");
    xmlhttp.setRequestHeader('Access-Control-Allow-Origin','*');
    xmlhttp.setRequestHeader('Content-type','application/json');
    xmlhttp.send();
}

function del(propId){

    var xmlhttp = new XMLHttpRequest();

  
    xmlhttp.onload = function() {

        console.log(this.responseText);
  
        const myObj = JSON.parse(this.responseText);
    
        console.log(myObj['data']);
  
        if(myObj['data'] == 'success'){
            location.reload();
            // console.log('login');
            // window.location.replace(url+"etenev-web_final/dev/dashboard.html");
        }
    
    }
    
    xmlhttp.open("POST", url+"/api/properties/del?propId="+propId, true);
    // xmlhttp.send(json);
    // xmlhttp.setRequestHeader('Access-Control-Allow-Origin','*');
    // xmlhttp.setRequestHeader('Content-type','application/json');
    xmlhttp.send();
    return false;

}

function setDetaisl(){

    window.location.replace(url+"etenev-web_final/dev/dashboard.html");

     document.getElementById('propName').value = myObj['data'][key]['propName'];
     document.getElementById('propName').innerHTML = myObj['data'][key]['propName'];
    //    document.getElementById('propType').value,
    //    document.getElementById('listingType').value,
    //    document.getElementById('propDescription').value,
    //    document.getElementById('propContact').value,
    //    document.getElementById('propPrice').value,
    //   document.getElementById('propSize').value,
    //   document.getElementById('propLeaseType').value, 
    //   document.getElementById('propMonthlyPay').value,
    //   document.getElementById('propStatus').value,
    //    document.getElementById('propUnits').value,
    //   document.getElementById('propStatus').value,
    //  document.getElementById('propAvailableUnits').value,
    //  document.getElementById('propBeds').value,
    //  document.getElementById('propBaths').value,
    //    document.getElementById('propSqrfoot').value,
    //   document.getElementById('base64').value,
    //   image : imgsrc,


}

function getPropertywithValue(){


    // alert('welcome');
    const currentUrl = window.location.href;
    // console.log(currentUrl);


    // console.log(currentUrl.split("?").pop());
    var propId = currentUrl.split("?").pop();

    console.log(propId);

    // if(window.location.toString().indexOf("?") != -1){
    //     console.log('not containing');
    // }

    if(window.location.toString().includes("?")){
        
        var xmlhttp = new XMLHttpRequest();

        xmlhttp.onload = function() {
    
        
            const myObj = JSON.parse(this.responseText);
        
            console.log(myObj['data']);

            document.getElementById('propDetName').innerHTML=myObj['data'][0]['propName'];
            document.getElementById('propDetSqf').innerHTML=myObj['data'][0]['propSqrfoot'];
            document.getElementById('propDetBeds').innerHTML=myObj['data'][0]['propBeds'];
            document.getElementById('propDetBaths').innerHTML=myObj['data'][0]['propBaths'];
            document.getElementById('propDescription').innerHTML=myObj['data'][0]['propDescription'];
            document.getElementById('propDetPrice').innerHTML=myObj['data'][0]['propPrice'];
            document.getElementById('propDetmainImage').src=url+'/'+myObj['data'][0]['image'];
        
        }


        xmlhttp.open("GET", url+"/api/properties/list?propId="+propId, true);
        xmlhttp.send();
        
    }else{

        window.location.replace(url+"/site/404.html");
        // var xmlhttp = new XMLHttpRequest();

        // xmlhttp.onload = function() {
    
        
        //     const myObj = JSON.parse(this.responseText);
        
        //     console.log(myObj['data']);
        
        // }


        // xmlhttp.open("GET", url+"/api/properties/list", true);
        // xmlhttp.send();
    
    }

   

}





