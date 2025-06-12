$(function () {
  $("#task-list").sortable({
    update: function () {
      var order = $(this).sortable("toArray", { attribute: "data-id" });
      $.ajax({
        url: "reorder_tasks.php",
        method: "POST",
        data: JSON.stringify(order),
        contentType: "application/json",
      });
    },
    start: function (e, ui) {
      ui.item.css({
        boxShadow: "0 8px 24px rgba(99,102,241,0.18)",
        transform: "scale(1.03)",
      });
    },
    stop: function (e, ui) {
      ui.item.css({
        boxShadow: "",
        transform: "",
      });
    },
  });

  // Animate task removal
  $("#task-list").on("click", 'a[href^="delete_task.php"]', function (e) {
    e.preventDefault();
    var $li = $(this).closest("li");
    var href = $(this).attr("href");
    $li.addClass("removing");
    setTimeout(function () {
      window.location = href;
    }, 400); // Match CSS transition duration
  });

  // Animate task completion toggle (optional, for visual feedback)
  $("#task-list").on("click", 'a[href^="mark_done.php"]', function () {
    var $li = $(this).closest("li");
    $li.addClass("removing");
    setTimeout(function () {
      // Let the server reload the page
    }, 400);
  });
});
