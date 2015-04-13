<?php
class Storytelling__metabox
{

    public function __construct()
    {
        load_textdomain('storytelling', STORY_DIR . 'lang/story-' . get_locale() . '.mo');
        add_action( 'add_meta_boxes', array($this, 'story__addMetaBox__Sidebar') );
    }

    public function story__addMetaBox__Sidebar(){
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
                'story__selector',
                __( 'Add a chapter', 'storytelling' ),
                array($this, 'story__addMetaBox__Sidebar__callback'),
                $screen,
                'side',
                'core'
            );

        }

    }

    public function story__addMetaBox__Sidebar__callback(){

        // --------------------------------------------------------------------
        // fonction qui affiche la meta dans la sidebar
        // --------------------------------------------------------------------

        // note : 
        // structure des folders :
        // plugin : templates/**nom**
        // themes : storytelling/**nom**

        // les templates à la racine du dossier ne seront pas lus

        $story_structure = new Storytelling__structure();
        $theme_template = $story_structure->Storytelling__register__Theme__folder();
        $plugin_template = $story_structure->Storytelling__register__Plugin__folder();

        // log_it($theme_template);
        // log_it($plugin_template);

        // ici on pourra aller chercher tout les templates inclut dans le dossier default du plugin

            // on parcourt les templates et on les affiche
        ?>
        <select id="storytelling__folder__selector">
            <?php

                // on lit en premier les dossiers du thème
                // puis les folders du plugins
                    // dans les folders il y a aura toujours le dossier default

                foreach ($plugin_template as $key => $value) {

                    if( gettype($value) === "array" ){

            ?>
            <option value="storytelling-plugin-<?=$key?>">Plugin <?=$key?></option>
            <?php

                    }

                }

            ?>
            <?php

                // on lit en premier les dossiers du thème
                // puis les folders du plugins
                    // dans les folders il y a aura toujours le dossier default

                foreach ($theme_template as $key => $value) {

                    if( gettype($value) === "array" ){

            ?>
            <option value="storytelling-theme-<?=$key?>">Theme <?=$key?></option>
            <?php

                    }

                }

            ?>
        </select>

        <?php

                foreach ($plugin_template as $key_parent => $value) {

                    if( gettype($value) === "array" ){

                        ?>                
        <ol id="storytelling-plugin-<?=$key_parent?>">
                        <?php

                        foreach ($value as $template) {

                            $template = json_decode($template);

                            $elements = [];
                            foreach( $template->elements as $key => $element ):
                                $elements[] = $element->type;
                            endforeach;
                            $structure = implode(',', $elements);

                            $elements = [];
                            foreach( $template->elements as $key => $element ):
                                $elements[] = $element->slug;
                            endforeach;
                            $slugs = implode(',', $elements);

                    ?>

                            <li>
                                <a href="#" 
                                data-type="plugin"
                                data-folder="<?=$key_parent?>"
                                data-file="<?=$template->file?>" 
                                data-name="<?=$template->name?>" 
                                data-structure="<?=$structure?>" 
                                data-slugs="<?=$slugs?>">
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
                    <?php

                    }

                }

        ?>

        <?php

                foreach ($theme_template as $key_parent => $value) {

                    if( gettype($value) === "array" ){

                        ?>                
        <ol id="storytelling-theme-<?=$key_parent?>">
                        <?php

                        foreach ($value as $template) {

                            $template = json_decode($template);

                            $elements = [];
                            foreach( $template->elements as $key => $element ):
                                $elements[] = $element->type;
                            endforeach;
                            $structure = implode(',', $elements);

                            $elements = [];
                            foreach( $template->elements as $key => $element ):
                                $elements[] = $element->slug;
                            endforeach;
                            $slugs = implode(',', $elements);

                    ?>

                            <li>
                                <a href="#" 
                                data-type="theme"
                                data-folder="<?=$key_parent?>"
                                data-file="<?=$template->file?>" 
                                data-name="<?=$template->name?>" 
                                data-structure="<?=$structure?>" 
                                data-slugs="<?=$slugs?>">
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
                    <?php

                    }

                }

        ?>

        <?php

    }

}