<?php

  /**
   * Our primary class View
   */
  class View {
      /**
       * View given page
       *
       * @param $content_view Content we want to view
       *
       * @param $template_view The given template
       *
       * @param $data Optional data provided
       */
      function generate_view($content_view, $template_view, $data = NULL)
      {
          if ($data) {
              extract($data);
          }

          include 'view/template/' . $template_view;
      }
  }

?>
