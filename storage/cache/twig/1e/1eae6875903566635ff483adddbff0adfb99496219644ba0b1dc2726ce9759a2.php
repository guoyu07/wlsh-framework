<?php

/* index/redis.html */
class __TwigTemplate_f1451e696a428e69b35f8ac802805d8b2e87d94aacb8ec697f0dc5b4beff3379 extends Twig_Template
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
<html lang=\"en\">
<head>
    <meta charset=\"UTF-8\">
    <title>Title</title>
</head>
<body>
 key: ";
        // line 8
        echo twig_escape_filter($this->env, ($context["key"] ?? null), "html", null, true);
        echo "
</body>
</html>";
    }

    public function getTemplateName()
    {
        return "index/redis.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  28 => 8,  19 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("<!DOCTYPE html>
<html lang=\"en\">
<head>
    <meta charset=\"UTF-8\">
    <title>Title</title>
</head>
<body>
 key: {{ key }}
</body>
</html>", "index/redis.html", "/var/www/html/YafUnit/application/views/index/redis.html");
    }
}
