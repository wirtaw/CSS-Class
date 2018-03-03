function unhide(divID){var item=document.getElementById(divID);if(item){item.className=(item.className=='hidden')?'unhidden':'hidden';}}
function calculate_chars(){var txt=document.getElementById('area1').value;document.getElementById('ch_num').value=txt.length+1;}
function toRGBHex(num)
{var decToHex="";var arr=new Array();var numStr=new String();numStr=num;arr=numStr.split(",");for(var i=0;i<3;i++)
{var hexArray=new Array("0","1","2","3","4","5","6","7","8","9","A","B","C","D","E","F");var code1=Math.floor(arr[i]/16);var code2=arr[i]-code1*16;decToHex+=hexArray[code1];decToHex+=hexArray[code2];}
return(decToHex);}
function chch(s){var v=document.getElementById(s).style.backgroundColor;white=toRGBHex('255,255,255');alert(" "+v+" "+white+" ");if(v=="FFFFFF"){document.getElementById(s).style.backgroundColor="6666FF";}else{document.getElementById(s).style.backgroundColor="FFFFFF";}}
function sub_forms(let){var form=document.createElement("form"),tmp;form.action=self.location;form.method="post";form.id="__id__tmp_form_for_post_submit";tmp=document.createElement("input");tmp.type="hidden";tmp.name="showletter";tmp.value=let;form.appendChild(tmp);document.body.appendChild(form);form.submit();}
function sub_forms2(let){var form=document.createElement("form"),tmp;form.action=self.location;form.method="post";form.id="__id__tmp_form_for_post_submit";for(var param in let){tmp=document.createElement("input");tmp.type="hidden";tmp.name="showletter";tmp.value=let[param];form.appendChild(tmp);}
document.body.appendChild(form);form.submit();}
function sub_forms3(n){var form=document.createElement("form"),tmp;form.action=self.location;form.method="post";form.id="__id__tmp_form_for_post_submit";tmp=document.createElement("input");tmp.type="hidden";tmp.name="cutter";tmp.value=n;form.appendChild(tmp);document.body.appendChild(form);form.submit();}
function add_under(str){alert(" "+str+" ");}
function showResult(str)
{if(str.length==0)
{document.getElementById("livesearch").innerHTML="";document.getElementById("livesearch").style.border="0px";document.getElementById("livesearch").display="none;";return;}
if(window.XMLHttpRequest)
{xmlhttp=new XMLHttpRequest();}else
{xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");}
xmlhttp.onreadystatechange=function()
{if(xmlhttp.readyState==4&&xmlhttp.status==200){
document.getElementById("livesearch").innerHTML=xmlhttp.responseText;document.getElementById("livesearch").style.border="1px solid #A5ACB2";document.getElementById("livesearch").display="block;";}}