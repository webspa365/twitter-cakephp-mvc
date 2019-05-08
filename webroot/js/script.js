var _id = function(id) {
  var id = id.replace('#', '');
  return document.getElementById(id);
}

var _cn = function(cn) {
  var cn = cn.replace('.', '');
  return document.getElementsByClassName(cn);
}

var _ = function(qs) {
  var ele = document.querySelector(qs);
  return ele;
}

var _all = function(id) {
  return document.querySelectorAll(id);
}

var set_css = function(ele, obj) {
  if(typeof ele == 'string') {
    ele = _(ele);
  }
  if(!ele.length) {
    Object.assign(ele[0].style, obj);
  } else {
    Object.assign(ele.style, obj);
  }
}

var get_now = function(time) {
  //var d = new Date(time*1000);
  var d = new Date(time);
  return d.getFullYear()+'-'+(d.getMonth()+1)+'-'+d.getDate()+' '+d.getHours()+':'+d.getMinutes()+':'+d.getSeconds();
}

var from_now = function(oldTime) {
  var msPerMinute = 60 * 1000;
  var msPerHour = msPerMinute * 60;
  var msPerDay = msPerHour * 24;
  var msPerMonth = msPerDay * 30;
  var msPerYear = msPerDay * 365;
  var d = new Date();
  var now = d.getTime()+(msPerHour*9);
  //var n = d.getTimezoneOffset();
  var elapsed = now - (oldTime+(msPerHour*9)); // - (60000*n));
  var val = 0;

  if (elapsed < msPerMinute) {
    val = Math.round(elapsed/1000);
    return val + ' second'+_s(val)+' ago';
  }

  else if (elapsed < msPerHour) {
    val = Math.round(elapsed/msPerMinute);
    return val + ' minute'+_s(val)+' ago';
  }

  else if (elapsed < msPerDay ) {
    val = Math.round(elapsed/msPerHour);
    return val + ' hour'+_s(val)+' ago';
  }

  else if (elapsed < msPerMonth) {
    val = Math.round(elapsed/msPerDay);
    return val + ' day'+_s(val)+' ago';
  }

  else if (elapsed < msPerYear) {
    val = Math.round(elapsed/msPerMonth);
    return  val + ' month'+_s(val)+' ago';
  }

  else {
    val = Math.round(elapsed/msPerYear);
    return val + ' year'+_s(val)+' ago';
  }

  function _s(val) {
    if(val < 2) return '';
    else return 's';
  }
}

function add_event(ele, name, cb) {
  ele.addEventListener(name, function() {
    cb();
  });
}

(function() {

})();

function open_menu(id) {
  //console.log('t.children='+JSON.stringify(t.children));
  //var menu = t.children[1];
  //console.log(e.target.id);
  //var menu = e.target;
  console.log('tweetMenuId='+id);
  var menu = _id(id);
  if(menu.style.display === 'none') menu.style.display = 'inline-block';
  else menu.style.display = 'none';
}
