<?php wp_oembed_add_provider( 'https://gamepath.io/*', 'https://gamepath.io/' ); ?>

<?php

class My_Plugin {

  var $oembed_endpoint;
  var $oembed_format;

  function __construct()
  {
    $this->oembed_endpoint = "http://mysuperawesomevideosite.com";
    $this->oembed_format = "http://mysuperawesomevideosite.com/video/*";

    $this->new_oembed();
  }

  function __destruct() {}

  function new_oembed()
  {
    wp_oembed_add_provider( $this->oembed_format, $this->oembed_endpoint );
  }

}
?>