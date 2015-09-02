<?php

/* base.html.twig */
class __TwigTemplate_4d497641b2ba9fd6c9cf84860125a76d95b71a9bbcb75e1c3bc1e65c7d35c83c extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'title' => array($this, 'block_title'),
            'stylesheets' => array($this, 'block_stylesheets'),
            'header' => array($this, 'block_header'),
            'body' => array($this, 'block_body'),
            'footer' => array($this, 'block_footer'),
            'javascripts' => array($this, 'block_javascripts'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $__internal_c5145cc8a9245d83089466b8ced9fd15cdd8ddd360b4f0b5b7f1cb880b55ca1a = $this->env->getExtension("native_profiler");
        $__internal_c5145cc8a9245d83089466b8ced9fd15cdd8ddd360b4f0b5b7f1cb880b55ca1a->enter($__internal_c5145cc8a9245d83089466b8ced9fd15cdd8ddd360b4f0b5b7f1cb880b55ca1a_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "base.html.twig"));

        // line 1
        echo "<!DOCTYPE html>
<html>
    <head>
        <meta charset=\"UTF-8\" />
        <title>";
        // line 5
        $this->displayBlock('title', $context, $blocks);
        echo "</title>
        ";
        // line 6
        $this->displayBlock('stylesheets', $context, $blocks);
        // line 7
        echo "        <link rel=\"icon\" type=\"image/x-icon\" href=\"";
        echo twig_escape_filter($this->env, $this->env->getExtension('asset')->getAssetUrl("favicon.ico"), "html", null, true);
        echo "\" />
    </head>
    <body>
        ";
        // line 10
        $this->displayBlock('header', $context, $blocks);
        // line 11
        echo "        ";
        $this->displayBlock('body', $context, $blocks);
        // line 12
        echo "        ";
        $this->displayBlock('footer', $context, $blocks);
        // line 13
        echo "        ";
        $this->displayBlock('javascripts', $context, $blocks);
        // line 14
        echo "    </body>
</html>
";
        
        $__internal_c5145cc8a9245d83089466b8ced9fd15cdd8ddd360b4f0b5b7f1cb880b55ca1a->leave($__internal_c5145cc8a9245d83089466b8ced9fd15cdd8ddd360b4f0b5b7f1cb880b55ca1a_prof);

    }

    // line 5
    public function block_title($context, array $blocks = array())
    {
        $__internal_e994e015c53f9e6831e3ef873da5c53271f42e126567b8aaee83aefc4332d527 = $this->env->getExtension("native_profiler");
        $__internal_e994e015c53f9e6831e3ef873da5c53271f42e126567b8aaee83aefc4332d527->enter($__internal_e994e015c53f9e6831e3ef873da5c53271f42e126567b8aaee83aefc4332d527_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "title"));

        echo "Welcome!";
        
        $__internal_e994e015c53f9e6831e3ef873da5c53271f42e126567b8aaee83aefc4332d527->leave($__internal_e994e015c53f9e6831e3ef873da5c53271f42e126567b8aaee83aefc4332d527_prof);

    }

    // line 6
    public function block_stylesheets($context, array $blocks = array())
    {
        $__internal_bcb43d63c657b04c6427e63ec6a93a35b88e71b7e128e3b0894450a95b85135b = $this->env->getExtension("native_profiler");
        $__internal_bcb43d63c657b04c6427e63ec6a93a35b88e71b7e128e3b0894450a95b85135b->enter($__internal_bcb43d63c657b04c6427e63ec6a93a35b88e71b7e128e3b0894450a95b85135b_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "stylesheets"));

        
        $__internal_bcb43d63c657b04c6427e63ec6a93a35b88e71b7e128e3b0894450a95b85135b->leave($__internal_bcb43d63c657b04c6427e63ec6a93a35b88e71b7e128e3b0894450a95b85135b_prof);

    }

    // line 10
    public function block_header($context, array $blocks = array())
    {
        $__internal_946168de3cb9aac534eeb45000f34d736ecb5bee6a6f7fd8432743db234b1ce7 = $this->env->getExtension("native_profiler");
        $__internal_946168de3cb9aac534eeb45000f34d736ecb5bee6a6f7fd8432743db234b1ce7->enter($__internal_946168de3cb9aac534eeb45000f34d736ecb5bee6a6f7fd8432743db234b1ce7_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "header"));

        
        $__internal_946168de3cb9aac534eeb45000f34d736ecb5bee6a6f7fd8432743db234b1ce7->leave($__internal_946168de3cb9aac534eeb45000f34d736ecb5bee6a6f7fd8432743db234b1ce7_prof);

    }

    // line 11
    public function block_body($context, array $blocks = array())
    {
        $__internal_0a3d21306c747e762789520b44925fe168e1209c27f86fb6f685ace506409b32 = $this->env->getExtension("native_profiler");
        $__internal_0a3d21306c747e762789520b44925fe168e1209c27f86fb6f685ace506409b32->enter($__internal_0a3d21306c747e762789520b44925fe168e1209c27f86fb6f685ace506409b32_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "body"));

        
        $__internal_0a3d21306c747e762789520b44925fe168e1209c27f86fb6f685ace506409b32->leave($__internal_0a3d21306c747e762789520b44925fe168e1209c27f86fb6f685ace506409b32_prof);

    }

    // line 12
    public function block_footer($context, array $blocks = array())
    {
        $__internal_03e468c525d5b2d1d31af186058ccf5e7dce0c69b2cb4e933113997eb1f31067 = $this->env->getExtension("native_profiler");
        $__internal_03e468c525d5b2d1d31af186058ccf5e7dce0c69b2cb4e933113997eb1f31067->enter($__internal_03e468c525d5b2d1d31af186058ccf5e7dce0c69b2cb4e933113997eb1f31067_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "footer"));

        
        $__internal_03e468c525d5b2d1d31af186058ccf5e7dce0c69b2cb4e933113997eb1f31067->leave($__internal_03e468c525d5b2d1d31af186058ccf5e7dce0c69b2cb4e933113997eb1f31067_prof);

    }

    // line 13
    public function block_javascripts($context, array $blocks = array())
    {
        $__internal_7eeaf337773aa75026ade6aee05a34826c4b76b1e22f5a787048b769b568f488 = $this->env->getExtension("native_profiler");
        $__internal_7eeaf337773aa75026ade6aee05a34826c4b76b1e22f5a787048b769b568f488->enter($__internal_7eeaf337773aa75026ade6aee05a34826c4b76b1e22f5a787048b769b568f488_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "javascripts"));

        
        $__internal_7eeaf337773aa75026ade6aee05a34826c4b76b1e22f5a787048b769b568f488->leave($__internal_7eeaf337773aa75026ade6aee05a34826c4b76b1e22f5a787048b769b568f488_prof);

    }

    public function getTemplateName()
    {
        return "base.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  123 => 13,  112 => 12,  101 => 11,  90 => 10,  79 => 6,  67 => 5,  58 => 14,  55 => 13,  52 => 12,  49 => 11,  47 => 10,  40 => 7,  38 => 6,  34 => 5,  28 => 1,);
    }
}
