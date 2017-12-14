<?php

/* index/index.html */
class __TwigTemplate_56a73538f0bb2f012a873095a2622501e2125139320113423e0f2e3ec7fcdc69 extends Twig_Template
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
<h1>twig: ";
        // line 7
        echo twig_escape_filter($this->env, ($context["content"] ?? null), "html", null, true);
        echo " I am  ";
        echo twig_escape_filter($this->env, ($context["name"] ?? null), "html", null, true);
        echo "</h1>
</body>
</html>
";
    }

    public function getTemplateName()
    {
        return "index/index.html";
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
<h1>twig: {{ content }} I am  {{ name }}</h1>
</body>
</html>
", "index/index.html", "/var/www/html/YafUnit/application/views/index/index.html");
    }
}
