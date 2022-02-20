//--------------------------------------------------
//現在日付、現在時間のリアルタイム更新
//--------------------------------------------------
const setNowTime = () =>{
  let newDate  = new Date();
  let nowYear  = newDate.getFullYear();
  let nowMonth = ('0'+(newDate.getMonth()+1)).slice(-2);
  let nowDay   = ('0'+newDate.getDate()).slice(-2);
  let nowHour  = ('0'+newDate.getHours()).slice(-2);
  let nowMin   = ('0'+newDate.getMinutes()).slice(-2);
  let nowSec   = ('0'+newDate.getSeconds()).slice(-2);

  document.getElementById('get_date').textContent=nowYear + "年" + nowMonth + "月" + nowDay +'日';
  document.getElementById('get_time').textContent=nowHour + ":" + nowMin + ":" + nowSec;
  document.getElementById('set_date').value=nowYear + nowMonth + nowDay;
  document.getElementById('set_time').value=nowHour + nowMin + nowSec;
  refresh();
}
const refresh = () =>{
  setTimeout(setNowTime,1000);
}
