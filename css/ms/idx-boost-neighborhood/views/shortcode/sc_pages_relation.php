<?php
 if( count($list_pages_silo)>0 ){  ?>
              <?php foreach($list_pages_silo as $item){ 
                      $id_page_relation=get_post_meta( $item['ID'], 'tgpost_relacion_communitity', true );
                      $permalink_silo = get_permalink($item['ID']);
                      $class_page='';
                      if (get_the_ID()==$item['ID'])
                        $class_page='class="active"';

                      $htmldata .='<li><a '.$class_page.' href="'.$permalink_silo.'" title="'.$item['post_title'].'">'.$item['post_title'].'</a></li>';
                    } 
?>
  

<?php 
$post_thumbnail_id = get_post_thumbnail_id($atts['id_neighoardhood']);
$post_thumbnail_url = wp_get_attachment_url($post_thumbnail_id);                                         
?>
<div class="content-nav">
          <ul class="list-nav-aside">
            <?php echo $htmldata; ?>
          </ul>
        </div>
<?php } ?>


<style>
.card-neightborhood{
    background-color: #333;
    padding: 10px;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-pack: justify;
    -ms-flex-pack: justify;
    justify-content: space-between;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    margin: 16px 0;
    position: relative;
  }

  .card-neightborhood .card-neightborhood-img{
    width: 100px;
    height: 54px;
    position: relative;
    -ms-flex-negative: 0;
    flex-shrink: 0;
    margin-right: 15px;  
  }

  .card-neightborhood .card-neightborhood-img img{
    background-position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    -o-object-fit: cover;
    object-fit: cover;
  }

  .card-neightborhood-detail{
    width: 67%;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-orient: vertical;
    -webkit-box-direction: normal;
        -ms-flex-direction: column;
            flex-direction: column;
    -webkit-box-align: start;
        -ms-flex-align: start;
            align-items: flex-start;
    -webkit-box-pack: center;
        -ms-flex-pack: center;
            justify-content: center;
  }

  .card-neightborhood-detail h2{
    font-size: 16px;
    color: #FFF;
    font-weight: 600;
    -webkit-box-ordinal-group: 3;
        -ms-flex-order: 2;
            order: 2;
    text-transform: uppercase;
    white-space: nowrap;
    overflow: hidden;
    -o-text-overflow: ellipsis;
       text-overflow: ellipsis;
    display: block;
    width: 88%;
  }

  .card-neightborhood-detail h3{
    font-size: 13px;
    text-transform: uppercase;
    color: #FFF;
    -webkit-box-ordinal-group: 2;
        -ms-flex-order: 1;
            order: 1;
  }

  .card-neightborhood-detail span{
    font-size: 13px;
    color: #FFF;
    -webkit-box-ordinal-group: 4;
        -ms-flex-order: 3;
            order: 3;
  }

  .card-neightborhood .card-neightborhood-link{
    display: block;
    position: absolute;
    top: 0;
    left: 0;
    text-indent: -999999px;
    width: 100%;
    height: 100%;
    overflow: hidden;
  }
</style>