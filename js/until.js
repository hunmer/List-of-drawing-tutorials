
var g_favorite = local_readJson('favorite', []);
var g_config = local_readJson('config', {

});
var count = parseInt(getLocalItem('likeCount', 100));
$('#like_btn span').html(count);
updateStatus();

  function updateStatus(){
      if(parseInt(getLocalItem('isLiked', 0)) == 1){
        $('#like_btn i').css('cssText', 'color: red!important');
      }else{
        $('#like_btn i').css('cssText', '');
      }
    }

function local_saveJson(key, data) {
    if (window.localStorage) {
        key = 'vm_' + key;    // 添加前缀，防止串用
        data = JSON.stringify(data);
        return localStorage.setItem(key, data);
    }
    return false;
}

function local_readJson(key, defaul = '') {
    if(!window.localStorage) return defaul;
    key = 'vm_' + key;
    var r = JSON.parse(localStorage.getItem(key));
    return r === null ? defaul : r;
}

function getLocalItem(key, defaul = '') {
    var r = null;
    if(window.localStorage){
        r = localStorage.getItem('vm_' + key);
    }
    return r === null ? defaul : r;
}

function setLocalItem(key, value) {
    if(window.localStorage){
       return localStorage.setItem('vm_' + key, value);
    }
    return false;
}


function initFavorite(){
  var html = '';
  var d;
  for(var i=0; i<g_favorite.length;i++){
    d = g_favorite[i];
     html = html +
      `<div class="card col s6" style='height: 250px;' >
      <div class="card-image waves-effect waves-block waves-light">
        <img class="activator" src="`+d.img+`">
      </div>
      <div class="card-content">
        <span class="activator grey-text text-darken-4">`+d.title+`<i class="material-icons right bottom" onclick='closeCardrevea();'>more_vert</i></span>
      </div>
      <div class="card-reveal">
        <span class="card-title grey-text text-darken-4" style="margin-bottom: 17px;">`+d.title+`<i class="material-icons right">close</i></span>
        <ul class="collection">
        `;

        if(d.online != undefined){
          html = html +`<li class="collection-item" onclick="closeCardrevea(); openNew('https://neysummer2000-location.glitch.me/?id=`+d.online.id+`&title=`+ encodeURI(d.title)+`');"><i class="material-icons right">chrome_reader_mode</i>Read</li>`;
        }
        html = html +`<li class="collection-item" onclick='openDownloadConfirm("`+d.title+`", "`+d.lang+`");'><i class="material-icons right">file_download</i>Download</li>
          <li class="collection-item" onclick='closeCardrevea(); window.open("https://www.google.com/search?q=`+d.title+`")'><i class="material-icons right">search</i>Search</li>
          <li class="collection-item" onclick='removeFromFavorite("`+d.title+`", "`+d.lang+`");'><i class="material-icons right">delete</i>Remove</li>
        </ul>
      </div>
    </div>`;
  }
  $('#test2 .row').html(html);
}

function closeCardrevea(){
  $('#test2 .row .card-reveal').each(function(index, el) {
    if($(el).css('display') == 'block'){
      $(el).find('i')[0].click();
    }
  });
}

function openDownloadConfirm(title, lang){
  closeCardrevea();
  var i = isFavoritedbyKey(title, lang);
  if(i != -1){
    var d = g_favorite[i];
    console.log(d);

    var links = Object.values(d.link);
    if(d.online != undefined){
       links.splice(0, 0, 'http://pan-yz.chaoxing.com/download/downloadfile?fleid='+d.online.id+'&puid=142588570')
     //>directDownload<
    }
      var h = `<ul class="collection">`;
      for(var i=0;i<links.length;i++){
        h = h + `<li class="collection-item" `;
        if(links[i].indexOf('pan-yz.chaoxing.com') != -1){
          h = h + 'data-clipboard-text="'+links[i]+'" ';
        }else{
           h = h + `onclick="window.open('`+links[i]+`');"`;
        }
         h = h + '><i class="material-icons right">file_download</i>site '+(i+1)+'</li>';
      }
      h = h + '</ul>';
      $('#modal2').html(h).modal('open');
       initCopyDom('#modal2 .collection-item');
  }
}

function removeFromFavorite(title, lang){
 var i = isFavoritedbyKey(title, lang);
  if(i != -1){
    //var d = g_favorite[i];
      var h = `<div class="modal-content">
          <h3>Remove from Favorites</h3>
          <p>Sure?</p>
         <div class="modal-footer">
          <a href="javascript: void(0)" onclick='favorite(`+i+`, "`+title+`", "`+lang+`"); M.Modal.getInstance($("#modal2")).close();' class="waves-effect waves-green btn-flat" >Remove</a>
          <a href="javascript: void(0)" class="modal-close waves-effect waves-red btn-flat">Cancel</a>
          </div></div>`;
      $('#modal2').html(h).modal('open');
  }
}

function isFavoritedbyKey(title, lang){
    for(var i=0; i<g_favorite.length;i++){
      if(g_favorite[i].title == title && g_favorite[i].lang == lang){
        return i;
      }
    }
    return -1;
  }

function getIndexByKey(title, lang){
    for(var i=0; i<g_datas.length;i++){
      if(g_datas[i].title == title && g_datas[i].lang == lang){
        return i;
      }
    }
    return -1;
  }


  function favorite(index, title, lang){
      g_favorite.splice(index, 1);
     local_saveJson('favorite', g_favorite);
     $('#test2 .card:eq('+index+')').remove();

     var id = getIndexByKey(title, lang);
      if(id != -1){
        dom = $('i[data-index='+id+']');
        if(dom.length > 0){
             dom.html('star_border');
        }
      }
    }