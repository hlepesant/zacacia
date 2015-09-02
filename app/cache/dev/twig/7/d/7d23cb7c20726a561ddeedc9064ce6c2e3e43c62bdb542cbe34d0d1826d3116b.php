<?php

/* ZacaciaBundle:Default:index.html.twig */
class __TwigTemplate_7d23cb7c20726a561ddeedc9064ce6c2e3e43c62bdb542cbe34d0d1826d3116b extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("ZacaciaBundle::zacacia.html.twig", "ZacaciaBundle:Default:index.html.twig", 1);
        $this->blocks = array(
            'main' => array($this, 'block_main'),
            'footer' => array($this, 'block_footer'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "ZacaciaBundle::zacacia.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $__internal_399554f0d3575e6462b0f2625a133aafb4eaef4fd5399af393c0bbb024bd7933 = $this->env->getExtension("native_profiler");
        $__internal_399554f0d3575e6462b0f2625a133aafb4eaef4fd5399af393c0bbb024bd7933->enter($__internal_399554f0d3575e6462b0f2625a133aafb4eaef4fd5399af393c0bbb024bd7933_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "ZacaciaBundle:Default:index.html.twig"));

        $this->parent->display($context, array_merge($this->blocks, $blocks));
        
        $__internal_399554f0d3575e6462b0f2625a133aafb4eaef4fd5399af393c0bbb024bd7933->leave($__internal_399554f0d3575e6462b0f2625a133aafb4eaef4fd5399af393c0bbb024bd7933_prof);

    }

    // line 3
    public function block_main($context, array $blocks = array())
    {
        $__internal_8f1919e5b0de5d0e3e6bb6faff71c613b81a43b44804bcd9ce37abf43c092dc2 = $this->env->getExtension("native_profiler");
        $__internal_8f1919e5b0de5d0e3e6bb6faff71c613b81a43b44804bcd9ce37abf43c092dc2->enter($__internal_8f1919e5b0de5d0e3e6bb6faff71c613b81a43b44804bcd9ce37abf43c092dc2_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "main"));

        // line 4
        echo "Hello Hugues!
";
        
        $__internal_8f1919e5b0de5d0e3e6bb6faff71c613b81a43b44804bcd9ce37abf43c092dc2->leave($__internal_8f1919e5b0de5d0e3e6bb6faff71c613b81a43b44804bcd9ce37abf43c092dc2_prof);

    }

    // line 7
    public function block_footer($context, array $blocks = array())
    {
        $__internal_05b3c66ae712dd4b5986a77eb9d9910a767e83c08656cfefaaf38c3b39eb1fb2 = $this->env->getExtension("native_profiler");
        $__internal_05b3c66ae712dd4b5986a77eb9d9910a767e83c08656cfefaaf38c3b39eb1fb2->enter($__internal_05b3c66ae712dd4b5986a77eb9d9910a767e83c08656cfefaaf38c3b39eb1fb2_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "footer"));

        // line 8
        echo "a
";
        
        $__internal_05b3c66ae712dd4b5986a77eb9d9910a767e83c08656cfefaaf38c3b39eb1fb2->leave($__internal_05b3c66ae712dd4b5986a77eb9d9910a767e83c08656cfefaaf38c3b39eb1fb2_prof);

    }

    public function getTemplateName()
    {
        return "ZacaciaBundle:Default:index.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  55 => 8,  49 => 7,  41 => 4,  35 => 3,  11 => 1,);
    }
}
