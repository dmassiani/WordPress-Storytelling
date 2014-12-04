<?php
class MacroContentHammer__interface extends MacroContentHammer__Plugin
{
    public function __construct()
    {
        add_action( 'edit_page_form', array($this, 'init') );
    }

    public function init()
    {

        // add button
        // add selector with registered template

        ?>

        <div id="mch__container" class="meta-box-sortables ui-sortable">
            <div id="mch__rapper" class="postbox ">
                <div class="handlediv" title="Cliquer pour inverser."><br></div>
                <h3 class="hndle">
                    <span>
                       A traduire :: Ajouter une section macro contenu
                    </span>
                </h3>
                <div class="inside">
                


                    <div id="mch__selector">
                        <ol>

                    <?php

                        $templates = parent::MacroContentHammer__registerTemplates();

                        // on parcourt les templates et on les affiche

                        foreach ($templates as &$template) {
                            $template = json_decode($template);
                    ?>

                            <li>
                                <a href="#" data-name="<?=$template->name?>" data-structure="<?=$template->structure?>">
                                    <h4><?=$template->name?></h4>
                                    <p>
                                        <?=$template->description?>
                                    </p>
                                </a>
                            </li>

                    <?php
                        }
                    ?>

                        </ol>
                        <div class="clear">
                    </div>


                
                </div>
            </div>
        </div>

        <?php
 
    }

}