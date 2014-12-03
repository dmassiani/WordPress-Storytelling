<?php
class MacroContentHammer__addButton
{
    public function __construct()
    {
        add_action( 'edit_page_form', array($this, 'init') );
    }

    public function init()
    {

    	// add a button
    	$this->addButton();

    }

    public function addButton(){

        ?>

        <div id="normal-sortables" class="meta-box-sortables ui-sortable">
            <div id="aiosp" class="postbox ">
                <div class="handlediv" title="Cliquer pour inverser."><br></div>
                <h3 class="hndle">
                    <span>
                        Macro Content
                    </span>
                </h3>
                <div class="inside">
                
            	   <div class="macro-content-hammer" id="mch__init"> <a href="#" class="button button-primary button-large"><?php echo esc_html__( 'Add Macro Content', 'plugin_domain' ) ?></a> </div>
                
                </div>
            </div>
        </div>

        <?php
 
    }

}