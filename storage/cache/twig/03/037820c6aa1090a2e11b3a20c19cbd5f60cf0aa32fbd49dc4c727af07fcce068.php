<?php

/* error/error.html */
class __TwigTemplate_3cb1a788f115ae465b05f11c01c983154ebb2760bc5a10081e52506018c2a295 extends Twig_Template
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
        echo "<!DOCTYPE html>
<html>
<head>
    <title>Welcome to Yaf!</title>
</head>
<body>
<h1>Error Msg: ";
        // line 7
        echo twig_escape_filter($this->env, ($context["message"] ?? null), "html", null, true);
        echo "</h1>
</body>
</html>
";
    }

    public function getTemplateName()
    {
        return "error/error.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  27 => 7,  19 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("<!DOCTYPE html>
<html>
<head>
    <title>Welcome to Yaf!</title>
</head>
<body>
<h1>Error Msg: {{ message }}</h1>
</body>
</html>
", "error/error.html", "/var/www/html/wlsh-framework/application/views/error/error.html");
    }
}
