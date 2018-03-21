/**
 * Created by Administrator on 2016-12-08.
 */
var toGet = 0;
var nowPage =0;
var pageSize = 10;
function test() {
    alert(666);
}
function getPic(){
    $.ajax({
        url:'/cloudealbumflow/bg',
        type: "POST",
        data:{page:nowPage,pageSize:pageSize},
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        async:false,
        success:function (msg) {
            // alert(msg);

            // return;
            var appendTest = "";
            if(msg=="false"){
                retun;
            }
            picMsg = JSON.parse(msg);
            for(var i=0;i<picMsg.length;i++){
                if(picMsg[i].info){
                    var color = "red";
                    var love = "❤";
                }else{
                    var color = "black";
                    var love = "♡";
                }
                if(picMsg[i].nick_name==null||picMsg[i].nick_name==''||typeof(picMsg[i].nick_name)=='undefined' ){
                    var nickName = picMsg[i].name;
                }else{
                    var nickName = picMsg[i].nick_name;
                }
                appendTest+=
                    "<article class='white-panel'><a  href='upload/"
                    +picMsg[i].maxpic+"' data-lightbox='e1' data-title='"
                    +picMsg[i].title+"'><img src='upload/"+picMsg[i].minpic
                    +"' class='thumb'></a><h1><a>+</a><a id='good_"
                    +picMsg[i].id
                    +"' info='"
                    +picMsg[i].info
                    +"'>"
                    +picMsg[i].like
                    +"</a> <a href='##'style='text-decration:none;color:"+color+"' onclick='clickGood("+picMsg[i].id+")'>"+love+"</a></h1><h1><a>"+picMsg[i].title+"</a><a href='/i/people/"+picMsg[i].uid+"' style='float:right;text-decoration:none;'> @"+nickName+"</a></h1><p></p></article>"
            }
            $("#gallery-wrapper").append(appendTest);
          //  console.log(appendTest);
            toGet = 0;
        }
    });
}
$(window).scroll(function () {
    var scrollheight = $(window).scrollTop() + document.body.clientHeight;
    var height = $(document).height();
    var distance = parseInt(height) - parseInt(scrollheight);

    if(distance <=500 && toGet == 0){
        nowPage += 1;
        toGet = 1;
        getPic();
    }
})
