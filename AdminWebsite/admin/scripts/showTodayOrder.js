var xmlHttp;
function createXMLHttpRequest(){
    if(window.ActiveXObject){
        xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if(window.XMLHttpRequest){
        xmlHttp = new XMLHttpRequest();
    }
}
function start(){
    createXMLHttpRequest();
    var url="../../ajax/order/showTodayOrder.php";
    var page = GetQueryString('page');
    if(page!=null)
        url = url+'?page='+page;
    document.getElementById("mask").innerHTML = "刷新中";
    xmlHttp.open("GET",url,true);
    xmlHttp.onreadystatechange = callback;
    xmlHttp.send(null);
}
function callback(){
    if(xmlHttp.readyState == 4){
        if(xmlHttp.status == 200){
            document.getElementById("details").innerHTML = xmlHttp.responseText;
            //60s刷新一次
            setTimeout("start()",20000);
            document.getElementById("mask").innerHTML = "";
        }
    }
}

function GetQueryString(name)
{
    var reg = new RegExp("(^|&)"+ name +"=([^&]*)(&|$)");
    var r = window.location.search.substr(1).match(reg);
    if(r!=null)
        return r[2];
    else
        return null;
}