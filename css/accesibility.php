<?php 
/**
 * Template Name: Accesibility Page
 * Template Post Type: page
 */
get_header(); ?>

<div class="ms-access-content-terms">
    <h1>Accesibility</h1>
    <p>
      <strong>{{companyName}}</strong> is committed to providing
      an accessible website. If you have difficulty accessing content, have 
      difficulty viewing a file on the website, or notice any accessibility 
      problems, please contact us to 
      <strong>( {{contactEmail}} {{contactPhone}} )</strong> to specify the 
      nature of the accessibility issue and any assistive technology you use. 
      NAR will strive to provide the content you need in the format you 
      require.
    </p>
    <p>
      <strong>{{companyName}}</strong> welcomes your suggestions and 
      comments about improving ongoing efforts to increase the accessibility 
      of this website.
    </p>
    <h2>Web Accessibility Help</h2>
    <p>
      There are actions you can take to adjust your web browser to make 
      your web experience more accessible.
    </p>
    <div class="ms-access-accordion">

      <div class="accordion-item">
        <a>Why is the moon sometimes out during the day?</a>

        <div class="ms-access-content">
          <p>
            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed 
            do eiusmod tempor incididunt ut labore et dolore magna 
            aliqua. Elementum sagittis vitae et leo duis ut. Ut tortor 
            pretium viverra suspendisse potenti.
          </p>
        </div>
      </div>

      <div class="accordion-item">
        <a>Why is the sky blue?</a>

        <div class="ms-access-content">
          <p>
            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed 
            do eiusmod tempor incididunt ut labore et dolore magna 
            aliqua. Elementum sagittis vitae et leo duis ut. Ut tortor 
            pretium viverra suspendisse potenti.
          </p>
        </div>
      </div>

      <div class="accordion-item">
        <a>Will we ever discover aliens?</a>

        <div class="ms-access-content">
          <p>
            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed 
            do eiusmod tempor incididunt ut labore et dolore magna 
            aliqua. Elementum sagittis vitae et leo duis ut. Ut tortor 
            pretium viverra suspendisse potenti.
          </p>
        </div>
      </div>

      <div class="accordion-item">
        <a>How much does the Earth weigh?</a>

        <div class="ms-access-content">
          <p>
            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed 
            do eiusmod tempor incididunt ut labore et dolore magna 
            aliqua. Elementum sagittis vitae et leo duis ut. Ut tortor 
            pretium viverra suspendisse potenti.
          </p>
        </div>
      </div>

      <div class="accordion-item">
        <a>How do airplanes stay up?</a>

        <div class="ms-access-content">
          <p>
            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed 
            do eiusmod tempor incididunt ut labore et dolore magna 
            aliqua. Elementum sagittis vitae et leo duis ut. Ut tortor 
            pretium viverra suspendisse potenti.
          </p>
        </div>
      </div>
    </div>
  </div>
<?php get_footer();?>
<script type="text/javascript">
  jQuery(document).on('click', '.accordion-item a', function() {
    var $item = jQuery(this);

    if ($item.hasClass('active')) {
      $item.removeClass('active');
      $item.next().removeClass('active');
    } else {
      $item.addClass('active');
      $item.next().addClass('active');
    }
  })
</script>