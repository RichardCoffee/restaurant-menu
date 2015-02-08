
var rmp_items = { move_flag: false };

jQuery(function() {  
  jQuery( "#section-wrap" ).sortable({
    cursor: 'move',
    placeholder: "placeholder",
	start: function(event,ui) { rmp_items.move_flag = true; },
  });
  assignGroupSort('#section-wrap');
  assignItemSort('#section-wrap');
  jQuery('.addExtra').click(function(e)      { addDescExtra(this); });
  jQuery('.addGroup').click(function(e)      { addMenuGroup(this); });
  jQuery('.addItem').click(function(e)       { addMenuItem(this); });
  jQuery('.addPriced').click(function(e)     { addDescPriced(this); });
  jQuery('.addTagline').click(function(e)    { addTagline(this); });
  jQuery('.boxhandle').click(function(e)     { showhideMetaBox(this); });
  jQuery('.deleteGroup').click(function(e)   { deleteMenuGroup(this); });
  jQuery('.deleteItem').click(function(e)    { deleteMenuItem(this); });
  jQuery('.deleteSection').click(function(e) { deleteMenuSection(this); });
  jQuery('.deleteTagline').click(function(e) { deleteTagline(this); });
  jQuery('.updateTitle').change(function(e)  { updateTitle(this); });
  jQuery('.hide-status').click(function(e)   { showhideItem(e,this); });
});

function addDescExtra(el) {
  var cnt  = jQuery(el).attr('data-cnt');
  var desc = previousElementSibling(el.parentNode.parentNode);
  var name = jQuery(desc).find('textarea').first().attr('name');
  var newn = name.replace('[desc','[extra][line_'+cnt);
  var cloneme = document.getElementById('line-clone').children[0];
  var cloned  = jQuery(cloneme).clone(true);
  jQuery(cloned).appendTo(desc).find('input').first().attr('name',newn).focus();
  jQuery(el).attr('data-cnt',++cnt);
}

function addDescPriced(el) {
  var elcnt = previousElementSibling(el.parentNode).children[0];
  var cnt   = jQuery(elcnt).attr('data-cnt');
  var desc  = previousElementSibling(el.parentNode.parentNode);
  var name  = jQuery(desc).find('textarea').first().attr('name');
  var newn  = name.replace('[desc','[extra][line_'+cnt+'][desc');
  var newp  = name.replace('[desc','[extra][line_'+cnt+'][price');
  var cloneme = document.getElementById('priced-clone').children[0];
  var cloned  = jQuery(cloneme).clone(true);
  jQuery(cloned).appendTo(desc).find('input').first().attr('name',newn).focus();
  jQuery(cloned).find('input').eq(1).attr('name',newp);
  jQuery(elcnt).attr('data-cnt',++cnt);
  jQuery(el).parent().parent().parent().next().children().first().children().addClass('hidden');
  //var chk = jQuery(el).parent().parent().parent().next().children().first().attr('class');
  //console.log('check: '+chk);
  jQuery(el).parent().parent().parent().next().children().first().next().children().addClass('hidden');
}

function addMenuGroup(el) {
  var group   = previousElementSibling(el);
  var cloneme = document.getElementById('group-clone').children[0];
  var cloned  = jQuery(cloneme).clone(true);
  jQuery(cloned).appendTo(group);
  replaceGroupNames(cloned);
  assignGroupSort(cloned);
  assignItemSort(cloned);
  var box = jQuery(cloned).find('.boxhandle').first()[0];
  showhideMetaBox(box);
}

function addMenuItem(el) {
  var group   = previousElementSibling(previousElementSibling(el.parentNode));
  var cloneme = document.getElementById('item-clone').children[0];
  var cloned  = jQuery(cloneme).clone(true);
  jQuery(cloned).appendTo(group);
  replaceItemNames(cloned);
  assignItemSort(cloned);
  var box = jQuery(cloned).find('.boxhandle').first()[0];
  showhideMetaBox(box);
}

function addMenuSection(el) {
  var section = document.getElementById('section-wrap');
  var secCnt  = jQuery(section).data('cnt');
  var cloneme = document.getElementById('section-clone').children[0];
  var cloned  = jQuery(cloneme).clone(true);
  jQuery(cloned).insertBefore(el);
  replaceNames(cloned,'section','[section_'+secCnt+']');
  jQuery(cloned).find('.inside > :nth-child(2)').attr('data-section',secCnt);
  jQuery(section).data('cnt',++secCnt)
  jQuery('#section-wrap').sortable("refresh");
  assignGroupSort(cloned);
  var box = jQuery(cloned).find('.boxhandle').first()[0];
  showhideMetaBox(box);
}

function addTagline(el) {
  var tagdiv  = previousElementSibling(el.parentNode.parentNode);
  var cloneme = document.getElementById('tagline-clone').children[0];
  var cloned  = jQuery(cloneme).clone(true);
  jQuery(cloned).appendTo(tagdiv);
  var secCnt = jQuery(tagdiv).parent().parent().parent().data('section');
  var grpCnt = jQuery(tagdiv).prev().data('group');
  replaceNames(cloned,'section','[section_'+secCnt+']');
  replaceNames(cloned,'group','[group_'+grpCnt+']');
  jQuery(tagdiv).find('input').first().focus();
  jQuery(el).parent().next().removeClass('hidden');
  jQuery(el).parent().addClass('hidden');
}

function assignGroupSort(el) {
  jQuery(el).find('.groups').sortable({
    connectWith: '.groups',
    cursor: 'move',
    placeholder: 'placeholder',
	start: function(event,ui) { rmp_items.move_flag = true; },
	stop:  function(event,ui) { replaceGroupNames(ui.item); },
  });
}

function assignItemSort() {
  jQuery('.items' ).sortable({
    connectWith:'.items',
    cursor: 'move',
    placeholder: "placeholder",
	start: function(event,ui) { rmp_items.move_flag = true; },
	stop:  function(event,ui) { replaceItemNames(ui.item); },
  });
}

function deleteMenuItem(el) {
  var item = el.parentNode.parentNode;
  deleteMenuSection(item);
}

function deleteMenuGroup(el) {
  deleteMenuSection(el.parentNode);
}

function deleteMenuSection(el) {
  var meta = el.parentNode.parentNode;
  var ans  = confirm('Are you sure you want to do this?');
  if (ans) {
    var ans2 = confirm('Last chance!  This deletion is not reversable! Are you absolutely sure?');
	if (ans2) {
      jQuery(meta).remove();
	}
  }
}

function deleteTagline(el) {
  var tagdiv = previousElementSibling(el.parentNode.parentNode);
  jQuery(tagdiv.children[0]).remove();
  jQuery(el).parent().prev().removeClass('hidden');
  jQuery(el).parent().addClass('hidden');
}

function replaceGroupNames(el) {
  var secCnt = jQuery(el).parent().data('section');
  var grpCnt = jQuery(el).parent().next().data('cnt');
  replaceNames(el,'section','[section_'+secCnt+']');
  replaceNames(el,'group','[group_'+grpCnt+']');
  jQuery(el).find('.inside > :nth-child(2)').attr('data-group',grpCnt);
  jQuery(el).parent().next().data('cnt',++grpCnt);
}

function replaceItemNames(el) {
  var secCnt = jQuery(el).parent().parent().parent().parent().data('section');
  var grpCnt = jQuery(el).parent().data('group');
  var iCnter = jQuery(el).parent().next().next().children().first();
console.log(jQuery(iCnter).attr('class'))
  var itmCnt = jQuery(iCnter).data('cnt');
  replaceNames(el,'section','[section_'+secCnt+']');
  replaceNames(el,'group','[group_'+grpCnt+']');
  replaceNames(el,'item','[item_'+itmCnt+']');
  jQuery(iCnter).data('cnt',++itmCnt);
}

function replaceNames(el,oldPart,newPart) {
  jQuery(el).find('input[type=text], textarea').each(function() {
    var name = jQuery(this).attr('name');
	if (name) {
	  var patt = new RegExp('\\['+oldPart+'_(.*?)\\]');
	  var newName = name.replace(patt,newPart);
      jQuery(this).attr('name',newName);
	}
  });
}

function showhideItem(e,el) {
  e.preventDefault();
  var hide   = { mess: rmpText.asks, stat: 'no',  text: rmpText.hide };
  var show   = { mess: rmpText.askh, stat: 'yes', text: rmpText.show };
  var status = previousElementSibling(el);
  var action = (status.value=='yes') ? hide : show;
  if (confirm(action.mess)) {
	status.value = action.stat;
    el.innerHTML = action.text;
  }
}

function showhideMetaBox(box) {
  if (rmp_items.move_flag) {
    rmp_items.move_flag = false;
  } else {
    jQuery(box.parentNode.children[1]).toggleClass('hidden');
    jQuery(box.children[0]).toggleClass('fa-sort-asc').toggleClass('fa-sort-desc');
	if (jQuery(box.parentNode.children[1]).hasClass('hidden')) {
	} else {
	  scrollToElement(box);
	  jQuery(box).parent().find('input').first().focus();
	}
  }
}

function updateTitle(el) {
  var target = el.parentNode.parentNode.parentNode.parentNode.children[0].children[1].children[0];
  jQuery(target).text(jQuery(el).val());
}