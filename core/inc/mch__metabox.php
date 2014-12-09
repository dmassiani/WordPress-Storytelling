<?php
class MacroContentHammer__metabox
{
    public function __construct()
    {
        add_action( 'add_meta_boxes', array($this, 'mch__addMetaBox__Sidebar') );
    }

    public function mch__addMetaBox__Sidebar(){
        $screens = array( 'post', 'page' );

        $args = array(
            'public'   => true,
            '_builtin' => false
        );

        $output = 'objects'; // names or objects

        $post_types = get_post_types( $args, $output );

        // print_r($post_types);


        foreach ( $post_types  as $post_type ) {

            $screens[] = $post_type->name;

        }

        foreach ( $screens as $screen ) {

            add_meta_box(
                'mch__selector',
                __( 'Ajouter un macro contenu', 'macrocontenthammer' ),
                array($this, 'mch__addMetaBox__Sidebar__callback'),
                $screen,
                'side',
                'core'
            );

        }

    }

    public function mch__addMetaBox__Sidebar__callback(){

        $mch_structure = new MacroContentHammer__structure();
        $templates = $mch_structure->MacroContentHammer__register__templates();

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