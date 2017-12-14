<?php

/* error/error.html */
class __TwigTemplate_3c422ef7c7a931fe6dfc0714e7679233308ceeed95fe9da4accf1125bc7636a6 extends Twig_Template
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
echo \"Error Msg:\"  . \$exception->getMessage();
?>
";
    }

    public function getTemplateName()
    {
        return "error/error.html";
    }

    public function getDebugInfo()
    {
        return array (  19 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("<?php
echo \"Error Msg:\"  . \$exception->getMessage();
?>
", "error/error.html", "/var/www/html/YafUnit/application/views/error/error.html");
    }
}
