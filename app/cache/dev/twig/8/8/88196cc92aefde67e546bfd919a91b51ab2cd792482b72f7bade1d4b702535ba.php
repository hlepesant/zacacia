<?php

/* ZacaciaBundle::zacacia.html.twig */
class __TwigTemplate_88196cc92aefde67e546bfd919a91b51ab2cd792482b72f7bade1d4b702535ba extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'title' => array($this, 'block_title'),
            'stylesheets' => array($this, 'block_stylesheets'),
            'header' => array($this, 'block_header'),
            'main' => array($this, 'block_main'),
            'footer' => array($this, 'block_footer'),
            'javascripts' => array($this, 'block_javascripts'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $__internal_96ab1778aa57850c30f2e178fe29063e8f31e778a4aa53e3c23c1ed73d0bdee4 = $this->env->getExtension("native_profiler");
        $__internal_96ab1778aa57850c30f2e178fe29063e8f31e778a4aa53e3c23c1ed73d0bdee4->enter($__internal_96ab1778aa57850c30f2e178fe29063e8f31e778a4aa53e3c23c1ed73d0bdee4_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "ZacaciaBundle::zacacia.html.twig"));

        // line 1
        echo "<!DOCTYPE html>
<html>
    <head>
        <meta charset=\"UTF-8\" />
        <title>";
        // line 5
        $this->displayBlock('title', $context, $blocks);
        echo "</title>
        <!-- Compiled and minified CSS -->
        <link rel=\"stylesheet\" href=\"https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.0/css/materialize.min.css\">
        <link href=\"";
        // line 8
        echo twig_escape_filter($this->env, $this->env->getExtension('asset')->getAssetUrl("bundles/zacacia/css/zacacia.css"), "html", null, true);
        echo "\" rel=\"stylesheet\" />
        ";
        // line 9
        $this->displayBlock('stylesheets', $context, $blocks);
        // line 10
        echo "        <link rel=\"icon\" type=\"image/x-icon\" href=\"";
        echo twig_escape_filter($this->env, $this->env->getExtension('asset')->getAssetUrl("favicon.ico"), "html", null, true);
        echo "\" />
    </head>
    <body>
        <!-- header class=\"col s12 l13 light-blue darken-4\">
       \t    ";
        // line 14
        $this->displayBlock('header', $context, $blocks);
        // line 15
        echo "        </header -->
        <div class=\"navbar-fixed\">
        <nav>
        <div class=\"nav-wrapper light-blue darken-4\">
            <a href=\"#\" class=\"brand-logo right\">Logo</a>
            <ul id=\"nav-mobile\" class=\"left hide-on-med-and-down\">
                <li class=\"active\"><a href=\"";
        // line 21
        echo $this->env->getExtension('routing')->getPath("zacacia_platform");
        echo "\">Plateforms</a></li>
            </ul>
        </div>
        </nav>
        </div>

        <main>
            <div class=\"row\">
            \t<div class=\"col s2 teal lighten-2\">
            </div>
            <div class=\"col s9\">
            \t<div class=\"container\">
            ";
        // line 33
        $this->displayBlock('main', $context, $blocks);
        // line 34
        echo "            \t</div>
            </div>
        </main>

        <footer class=\"page-footer light-blue darken-4\">
        ";
        // line 39
        $this->displayBlock('footer', $context, $blocks);
        // line 40
        echo "\t</footer>

        <!-- Compiled and minified JavaScript -->
        <script src=\"https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.0/js/materialize.min.js\"></script>
        ";
        // line 44
        $this->displayBlock('javascripts', $context, $blocks);
        // line 45
        echo "    </body>
</html>
";
        
        $__internal_96ab1778aa57850c30f2e178fe29063e8f31e778a4aa53e3c23c1ed73d0bdee4->leave($__internal_96ab1778aa57850c30f2e178fe29063e8f31e778a4aa53e3c23c1ed73d0bdee4_prof);

    }

    // line 5
    public function block_title($context, array $blocks = array())
    {
        $__internal_6eeddbf62f906d99fd584e7717c8c7a7e96a162a206cddc56a056b5c7410f02d = $this->env->getExtension("native_profiler");
        $__internal_6eeddbf62f906d99fd584e7717c8c7a7e96a162a206cddc56a056b5c7410f02d->enter($__internal_6eeddbf62f906d99fd584e7717c8c7a7e96a162a206cddc56a056b5c7410f02d_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "title"));

        echo "Welcome!";
        
        $__internal_6eeddbf62f906d99fd584e7717c8c7a7e96a162a206cddc56a056b5c7410f02d->leave($__internal_6eeddbf62f906d99fd584e7717c8c7a7e96a162a206cddc56a056b5c7410f02d_prof);

    }

    // line 9
    public function block_stylesheets($context, array $blocks = array())
    {
        $__internal_683955dd2dbd7f4584b23a86cfe02d45906f3b3f6467c05349dd40dd3b1947a4 = $this->env->getExtension("native_profiler");
        $__internal_683955dd2dbd7f4584b23a86cfe02d45906f3b3f6467c05349dd40dd3b1947a4->enter($__internal_683955dd2dbd7f4584b23a86cfe02d45906f3b3f6467c05349dd40dd3b1947a4_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "stylesheets"));

        
        $__internal_683955dd2dbd7f4584b23a86cfe02d45906f3b3f6467c05349dd40dd3b1947a4->leave($__internal_683955dd2dbd7f4584b23a86cfe02d45906f3b3f6467c05349dd40dd3b1947a4_prof);

    }

    // line 14
    public function block_header($context, array $blocks = array())
    {
        $__internal_42aa743aa70d076c43f7fc580f942d5747feb4899dc4ee57fa7a43647fed3c0b = $this->env->getExtension("native_profiler");
        $__internal_42aa743aa70d076c43f7fc580f942d5747feb4899dc4ee57fa7a43647fed3c0b->enter($__internal_42aa743aa70d076c43f7fc580f942d5747feb4899dc4ee57fa7a43647fed3c0b_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "header"));

        
        $__internal_42aa743aa70d076c43f7fc580f942d5747feb4899dc4ee57fa7a43647fed3c0b->leave($__internal_42aa743aa70d076c43f7fc580f942d5747feb4899dc4ee57fa7a43647fed3c0b_prof);

    }

    // line 33
    public function block_main($context, array $blocks = array())
    {
        $__internal_4b8d61aaf76085e17d1b79e67716330d1199bfa927db892854547ef7c48ad81b = $this->env->getExtension("native_profiler");
        $__internal_4b8d61aaf76085e17d1b79e67716330d1199bfa927db892854547ef7c48ad81b->enter($__internal_4b8d61aaf76085e17d1b79e67716330d1199bfa927db892854547ef7c48ad81b_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "main"));

        
        $__internal_4b8d61aaf76085e17d1b79e67716330d1199bfa927db892854547ef7c48ad81b->leave($__internal_4b8d61aaf76085e17d1b79e67716330d1199bfa927db892854547ef7c48ad81b_prof);

    }

    // line 39
    public function block_footer($context, array $blocks = array())
    {
        $__internal_f59432b0d1c29c54af9d38e6c2e250bd5890847d00fcfcd7ca46f445e6a5ec62 = $this->env->getExtension("native_profiler");
        $__internal_f59432b0d1c29c54af9d38e6c2e250bd5890847d00fcfcd7ca46f445e6a5ec62->enter($__internal_f59432b0d1c29c54af9d38e6c2e250bd5890847d00fcfcd7ca46f445e6a5ec62_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "footer"));

        
        $__internal_f59432b0d1c29c54af9d38e6c2e250bd5890847d00fcfcd7ca46f445e6a5ec62->leave($__internal_f59432b0d1c29c54af9d38e6c2e250bd5890847d00fcfcd7ca46f445e6a5ec62_prof);

    }

    // line 44
    public function block_javascripts($context, array $blocks = array())
    {
        $__internal_1e90fde3d0192072f8f2a3656f38247f5be0659d591655947b5887449bbac957 = $this->env->getExtension("native_profiler");
        $__internal_1e90fde3d0192072f8f2a3656f38247f5be0659d591655947b5887449bbac957->enter($__internal_1e90fde3d0192072f8f2a3656f38247f5be0659d591655947b5887449bbac957_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "javascripts"));

        
        $__internal_1e90fde3d0192072f8f2a3656f38247f5be0659d591655947b5887449bbac957->leave($__internal_1e90fde3d0192072f8f2a3656f38247f5be0659d591655947b5887449bbac957_prof);

    }

    public function getTemplateName()
    {
        return "ZacaciaBundle::zacacia.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  163 => 44,  152 => 39,  141 => 33,  130 => 14,  119 => 9,  107 => 5,  98 => 45,  96 => 44,  90 => 40,  88 => 39,  81 => 34,  79 => 33,  64 => 21,  56 => 15,  54 => 14,  46 => 10,  44 => 9,  40 => 8,  34 => 5,  28 => 1,);
    }
}
