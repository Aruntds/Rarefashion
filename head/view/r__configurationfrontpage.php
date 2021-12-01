<?php
/*
* JACKUS - An In-house Framework for TDS Apps
*
* Author: Touchmark Descience Private Limited. 
* https://touchmarkdes.com
* Version 4.0.1
* Copyright (c) 2018-2020 Touchmark De`Science
*
*/
//Dont place PHP Close tag at the bottom
protectpg_includes();

//Insert Operation
if($save == 'save')

{

	//Store Front Page - Category Settings
	$frontpage_categoryshow = $_REQUEST['frontpage_categoryshow']; //value='on' == 1 || value='' == 0
	if($frontpage_categoryshow == 'on') { $categoryshow = '1'; } else { $categoryshow = '0'; }

	//Store Front Page - Featured Product Settings
	$frontpage_featuredshow = $_REQUEST['frontpage_featuredshow']; //value='on' == 1 || value='' == 0
	if($frontpage_featuredshow == 'on') { $featuredshow = '1'; } else { $featuredshow = '0'; }

	//Store Front Page - Blog Settings
	$frontpage_blogshow = $_REQUEST['frontpage_blogshow']; //value='on' == 1 || value='' == 0
	if($frontpage_blogshow == 'on') { $blogshow = '1'; } else { $blogshow = '0'; }

	$featured_product_list = $_REQUEST['frontpage_featuredproducts'];
	if( is_array($featured_product_list)) {
		while (list ($mkey, $mval) = each ($featured_product_list)) {
			$mstring .= $mval.",";
			$featured_products = substr($mstring,0,strlen($mstring)-1);
		}
	}
		
	$arrFields=array('`_settings_frontpage_categoryshow`','`_settings_frontpage_categoryID`','`_settings_frontpage_categoryitemcount`','`_settings_frontpage_categorysortby`','`_settings_frontpage_featuredshow`','`_settings_frontpage_featuredproducts`','`_settings_frontpage_blogshow`','`_settings_frontpage_blogcategoryID`','`createdby`');
	$arrValues=array("$categoryshow","$frontpage_categoryID","$frontpage_categoryitemcount","$frontpage_categorysortby","$featuredshow","$featured_products","$blogshow","$frontpage_blogcategoryID","$logged_user_id");

	if(sqlACTIONS("INSERT","js_settingfrontpage",$arrFields,$arrValues,''))
	{	
			
		echo "<div style='width: 350px; text-align: center; margin: 10% auto 0px; font-family: arial; font-size: 14px; border: 1px solid #ddd; padding: 20px 40px;'>Please wait while we update...</div>";
		?>
		<script type="text/javascript">window.location = 'configurationfrontpage.php?code=1' </script>
		<?php		
		
	}
}

//Update
if($update == "update" && $hidden_id != '') {

	//Store Front Page - Category Settings
	$frontpage_categoryshow = $_REQUEST['frontpage_categoryshow']; //value='on' == 1 || value='' == 0
	if($frontpage_categoryshow == 'on') { $categoryshow = '1'; } else { $categoryshow = '0'; }

	//Store Front Page - Featured Product Settings
	$frontpage_featuredshow = $_REQUEST['frontpage_featuredshow']; //value='on' == 1 || value='' == 0
	if($frontpage_featuredshow == 'on') { $featuredshow = '1'; } else { $featuredshow = '0'; }

	//Store Front Page - Blog Settings
	$frontpage_blogshow = $_REQUEST['frontpage_blogshow']; //value='on' == 1 || value='' == 0
	if($frontpage_blogshow == 'on') { $blogshow = '1'; } else { $blogshow = '0'; }

	$featured_product_list = $_REQUEST['frontpage_featuredproducts'];
	if( is_array($featured_product_list)) {
		while (list ($mkey, $mval) = each ($featured_product_list)) {
			$mstring .= $mval.",";
			$featured_products = substr($mstring,0,strlen($mstring)-1);
		}
	}
		
	$arrFields=array('`_settings_frontpage_categoryshow`','`_settings_frontpage_categoryID`','`_settings_frontpage_categoryitemcount`','`_settings_frontpage_categorysortby`','`_settings_frontpage_featuredshow`','`_settings_frontpage_featuredproducts`','`_settings_frontpage_blogshow`','`_settings_frontpage_blogcategoryID`','`createdby`');
	$arrValues=array("$categoryshow","$frontpage_categoryID","$frontpage_categoryitemcount","$frontpage_categorysortby","$featuredshow","$featured_products","$blogshow","$frontpage_blogcategoryID","$logged_user_id");
	
	$sqlWhere= "createdby=$hidden_id";

	if(sqlACTIONS("UPDATE","js_settingfrontpage",$arrFields,$arrValues, $sqlWhere)) {
		
		echo "<div style='width: 350px; text-align: center; margin: 10% auto 0px; font-family: arial; font-size: 14px; border: 1px solid #ddd; padding: 20px 40px;'>Please wait while we update...</div>";
			?>
			<script type="text/javascript">window.location = 'configurationfrontpage.php?code=2' </script>
			<?php
			//header("Location:category.php?code=1");
			
		exit();

	} else {

		$err[] =  "Unable to Update Record"; 

	}

}
?>

    <!-- container -->
   
    <div class="content">
      <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0">
        <div class="row">
          <div class="col-lg-9">
            <div class="mg-b-25">

          <form method="post" enctype="multipart/form-data" data-parsley-validate>
			<?php 
				$gettinglast_updated = getSINGLEDBVALUE('updatedon', "createdby=$logged_user_id", 'js_settingfrontpage', 'label');
				$formated_lastupdate_time = strtotime($gettinglast_updated);
				
				//checking record available
				$checkfrontpageRECORD = commonNOOFROWS_COUNT('js_settingfrontpage', "createdby=$logged_user_id");
			?>
            <div id="stick-here"></div>
            <div id="stickThis" class="form-group row mg-b-0">
                <div class="col-3 col-sm-6">
                  <p class="text-muted">Last Updated on : <?php echo time_stamp($formated_lastupdate_time); ?></p>
                </div>
                <div class="col-9 col-sm-6 text-right">
                    <?php if($checkfrontpageRECORD == 0) { ?>
                      <button type="submit" name="save" value="save" class="btn btn-success">Save</button>
                    <?php } else { ?>
                    <button type="submit" name="update" value="update" class="btn btn-warning">Update</button>
                      <input type="hidden" name="hidden_id" value="<?php echo $logged_user_id; ?>" />
                    <?php } ?>
                     </button>
                </div>
            </div>
            
			<?php 	
                 if($checkfrontpageRECORD > 0) {
                    $list_datas = sqlQUERY_LABEL("SELECT * FROM `js_settingfrontpage` where deleted = '0' and `createdby`='$logged_user_id'") or die("Unable to get records:".mysql_error());			
                    $check_record_availabity = sqlNUMOFROW_LABEL($list_datas);			
                    while($row = sqlFETCHARRAY_LABEL($list_datas)){
						//Store Front Page - Category Settings
						$_settings_frontpage_categoryshow = $row["_settings_frontpage_categoryshow"];
						$_settings_frontpage_categoryID = $row["_settings_frontpage_categoryID"];
						$_settings_frontpage_categoryitemcount = $row["_settings_frontpage_categoryitemcount"];
						$_settings_frontpage_categorysortby = $row["_settings_frontpage_categorysortby"];
						//Store Front Page - Product Settings
						$_settings_frontpage_featuredshow = $row["_settings_frontpage_featuredshow"];
						$_settings_frontpage_featuredproducts = $row["_settings_frontpage_featuredproducts"];
						//Store Front Page - Blog Settings
						$_settings_frontpage_blogshow = $row["_settings_frontpage_blogshow"];
						$_settings_frontpage_blogcategoryID = $row["_settings_frontpage_blogcategoryID"];
                    }
                }
				//1-by name, 2-created on, 3-totalviews
            ?>
    
            <!-- Category Listing -->
            <div id="categorylisting">
    
                <div class="divider-text">Category Listing</div>
    
                <div class="form-group row">
                    <label for="frontpage_categoryshow" class="col-sm-4 col-form-label">Display Category Listing<span class="tx-danger">*</span></label>
                    <div class="col-sm-8">
                        <div class="custom-control custom-switch">
                          <input type="checkbox" class="custom-control-input" name="frontpage_categoryshow" id="frontpage_categoryshow" <?php if($_settings_frontpage_categoryshow == '1') { echo 'checked=""'; } ?>>
                          <label class="custom-control-label" for="frontpage_categoryshow">Yes</label>
                        </div>
                    </div>
                </div>
                
                <div id="settings_frontpage_categorylistproducts" <?php if($_settings_frontpage_categoryshow == '0' || $_settings_frontpage_blogshow == '') { echo 'style="display:none;"';  }?>>
                    
                    <div class="form-group row">
                        <label for="frontpage_categoryID" class="col-sm-4 col-form-label">Category<span class="tx-danger">*</span></label>
                        <div class="col-sm-8">
                            <select class="custom-select" name="frontpage_categoryID" id="frontpage_categoryID">
                            <option value="0">Choose one</option>
                            <?php echo getPRODUCTCATEGORY($_settings_frontpage_categoryID, 'simpleselect', 'select'); ?>
                            </select>
                        </div>
                    </div>
    
                    <div class="form-group row">
                        <label for="frontpage_categoryitemcount" class="col-sm-4 col-form-label">No. of items to display<span class="tx-danger">*</span></label>
                        <div class="col-sm-8">
                            <select name="frontpage_categoryitemcount" id="frontpage_categoryitemcount" class="custom-select">
                                <?php
                                //generate foorloop 
                                for($i=5; $i<=25; $i+=5)
                                {
                                    echo "<option value='$i'";
                                    echo ($_settings_frontpage_categoryitemcount == $i) ? " selected='selected'": "";
                                    echo ">".$i."</option>";
                                }
                                ?> 
                            </select>
                        </div>
                    </div>
                                  
                    <div class="form-group row">
                        <label for="frontpage_categorysortby" class="col-sm-4 col-form-label">List Sort By<span class="tx-danger">*</span></label>
                        <div class="col-sm-8">
                            <select class="custom-select" name="frontpage_categorysortby" id="frontpage_categorysortby">
                                <?php echo customFRONTPAGECATALOGUESETTINGS($_settings_frontpage_categorysortby, 'select'); ?>
                            </select>
                        </div>
                    </div>
                
                </div>
    
            </div>
            <!-- End of Category Listing -->
                
            <!--  Store Front Page - Settings  -->
            <div id="storefront">
            
                <div class="divider-text">Featured Products</div>
                
                <div class="form-group row">
                    <label for="frontpage_featuredshow" class="col-sm-4 col-form-label">Show Featured Products<span class="tx-danger">*</span></label>
                    <div class="col-sm-8">
                    <div class="custom-control custom-switch">
                      <input type="checkbox" class="custom-control-input" name="frontpage_featuredshow" id="frontpage_featuredshow" <?php if($_settings_frontpage_featuredshow == '1') { echo 'checked=""'; } ?>>
                      <label class="custom-control-label" for="frontpage_featuredshow">Yes</label>
                    </div>
                    </div>
                </div>
               
                <div id="settings_frontpage_featuredproducts" class="form-group row" <?php if($_settings_frontpage_featuredshow == '0' || $_settings_frontpage_blogshow == '') { echo 'style="display:none;"';  }?> >
                    <label for="frontpage_featuredproducts" class="col-sm-4 col-form-label">Products</label>
                    <div class="col-sm-8">
                         <select name="frontpage_featuredproducts[]" id="frontpage_featuredproducts" multiple="multiple" class="form-control catalogue_searchproduct" style="width: 100%">
						 <?php echo (getsettingsFRONTPAGEPRODUCTS($_settings_frontpage_featuredproducts, 'show_selected')); ?>                         
                         </select>
                    	<span class="tx-10 mg-t-5 tx-orange">You can add maximum of 10 products</span>
                    </div>
                </div>
                
            </div>
            <!--  End of Store Front Page - Settings  -->
    
            <!-- Category Listing -->
            <div id="blogsettings">
    
                <div class="divider-text">Blog Listing</div>
    
                <div class="form-group row">
                    <label for="frontpage_blogshow" class="col-sm-4 col-form-label">Display Blog Listing<span class="tx-danger">*</span></label>
                    <div class="col-sm-8">
                        <div class="custom-control custom-switch">
                          <input type="checkbox" class="custom-control-input" name="frontpage_blogshow" id="frontpage_blogshow" <?php if($_settings_frontpage_blogshow == '1') { echo 'checked=""'; } ?>>
                          <label class="custom-control-label" for="frontpage_blogshow">Yes</label>
                        </div>
                    </div>
                </div>
                
                <div id="settings_frontpage_blog" class="form-group row" <?php if($_settings_frontpage_blogshow == '0' || $_settings_frontpage_blogshow == '') { echo 'style="display:none;"';  }?>>
                    <label for="frontpage_blogcategoryID" class="col-sm-4 col-form-label">Blog Category List<span class="tx-danger">*</span></label>
                    <div class="col-sm-8">
                        <select class="custom-select" name="frontpage_blogcategoryID" id="frontpage_blogcategoryID">
                        <option value="0">--</option>
                        </select>
                    </div>
                </div>
    
            </div>
            <!-- End of Category Listing -->
                                
        </form>

        </div><!-- row -->
      </div><!-- col -->
          
	  <?php 
        $catalog_sidebar_view_type='create';
        include viewpath('__configurationfrontpagesidebar.php'); 
      ?>

    </div><!-- row -->
  </div><!-- container -->
</div><!-- content -->