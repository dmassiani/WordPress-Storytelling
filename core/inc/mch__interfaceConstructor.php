<?php
class MacroContentHammer__interface extends MacroContentHammer__Plugin
{
    public function __construct()
    {

        add_action( 'add_meta_boxes', array($this, 'mch__addMetaBox__Sidebar') );
    }

    public function mch__addMetaBox__Sidebar(){
        $screens = array( 'post', 'page' );

        foreach ( $screens as $screen ) {

            add_meta_box(
                'mch__selector',
                __( 'Ajouter un macro contenu', 'myplugin_textdomain' ),
                array($this, 'mch__addMetaBox__Sidebar__callback'),
                $screen,
                'side',
                'core'
            );

            // add_meta_box(
            //     'mch__selector',
            //     __( 'Macro content', 'myplugin_textdomain' ),
            //     array($this, 'mch__addMetaBox__Content__callback'),
            //     $screen,
            //     'normal',
            //     'core'
            // );
            // echo 'mop';

        }

    }

    public function mch__addMetaBox__Sidebar__callback(){

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

    }

    public function mch__addMetaBox__Content__callback(){

    }

}