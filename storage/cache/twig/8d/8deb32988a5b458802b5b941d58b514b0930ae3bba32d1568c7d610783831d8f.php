<?php

/* index/index.html */
class __TwigTemplate_f27cadc7b669191ff841fabba67b54832e0b6f2cab395b5cf87751868b39f7dc extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<?php
echo \$content, \" I am \", \$name;
?>
";
    }

    public function getTemplateName()
    {
        return "index/index.html";
    }

    public function getDebugInfo()
    {
        return array (  19 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "index/index.html", "/var/www/html/YafUnit/application/views/index/index.html");
    }
}
