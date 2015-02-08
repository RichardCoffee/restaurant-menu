//

jQuery(document).ready(function() {
  showhideTab();
});

function showhideTab() {
  if (jQuery(".rmp-tab input:radio:checked").val()=='show') {
    jQuery('.rmp-tabInfo').parent().parent().removeClass('hidden');
  } else {
    jQuery('.rmp-tabInfo').parent().parent().addClass('hidden');
  }
}