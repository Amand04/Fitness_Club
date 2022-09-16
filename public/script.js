$(document).ready(function() {
  $("input[type='checkbox']").click(function() {
      let newsletter = [];
      $.each($("input[name='newsletter']:checked"), function() {
        newsletter.push($(this).val());
      });
      alert("Etes-vous sur de vouloir modifier l'autorisation: " + newsletter.join(", "));
  });
});



