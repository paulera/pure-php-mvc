<div class="container">
	<span style="border: 1px solid blue">Wow, that is the content</span>
</div>

<div class="container">

<?php Components::code('
class Voila {
  public:
  // Voila
  static const string VOILA = "Voila";

  // will not interfere with embedded <a href="#voila2">tags</a>.
}
', 'javascript')?>

</div>