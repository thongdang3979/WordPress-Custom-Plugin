<?php
// Globals.
global $ctl, $ctl_instances;

$ctl = array();
$ctl_instances = array();

/**
 * @return void
 */
function ctl_global(): void
{
    // Globals.
    global $ctl, $ctl_instances;
}

add_action('init', 'ctl_global');

/**
 * @param string $class
 *
 * @return mixed
 */
function ctl_new_instance(string $class = ''): object
{
    global $ctl_instances;
    return $ctl_instances[$class] = new $class();
}


/**
 * @param string $class
 *
 * @return mixed
 */
function ctl_get_instance(string $class = ''): mixed
{
    global $ctl_instances;
    if (!isset($ctl_instances[$class])) {
        $ctl_instances[$class] = new $class();
    }
    return $ctl_instances[$class];
}


/**
 * @param string $filename
 *
 * @return void
 */
function ctl_include(string $filename = ''): void
{
    $file_path = CTL_DIR . ltrim($filename, '/');
    if (file_exists($file_path)) {
        include_once $file_path;
    }
}

/**
 * @param string      $slug
 * @param string|null $name
 * @param array       $args
 * @param bool        $extract
 *
 */
function ctl_get_template_part(string $slug, string $name = null, array $args = array(), bool $extract = true): void
{
    $templates = array();

    // If a name is provided, add both "slug-name.php" and "slug.php" to the templates array
    if (!empty($name)) {
        $templates[] = "{$slug}-{$name}.php";
    }
    $templates[] = "{$slug}.php";

    // If templates are available
    if (!empty($templates)) {
        // Locate the template file
        $located_template = locate_template($templates, false, true);

        // If no template file is found but the first template exists as a file, set it as the located template
        if (empty($located_template) && file_exists($templates[0])) {
            $located_template = $templates[0];
        }

        // Extract variables from $args array and set them as local variables if provided and $extract is true
        if (!empty($args) && $extract) {
            extract($args);
        }

        // Include the located template file
        include_once $located_template;
    }
}
