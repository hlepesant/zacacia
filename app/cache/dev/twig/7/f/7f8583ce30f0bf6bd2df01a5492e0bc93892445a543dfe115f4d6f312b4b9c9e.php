<?php

/* TwigBundle:Exception:exception_full.html.twig */
class __TwigTemplate_7f8583ce30f0bf6bd2df01a5492e0bc93892445a543dfe115f4d6f312b4b9c9e extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("TwigBundle::layout.html.twig", "TwigBundle:Exception:exception_full.html.twig", 1);
        $this->blocks = array(
            'head' => array($this, 'block_head'),
            'title' => array($this, 'block_title'),
            'body' => array($this, 'block_body'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "TwigBundle::layout.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $__internal_5e11cbd38483b33c2f3ca0b1f45b24d54ec73dd726e2e98f382f40fe26427faf = $this->env->getExtension("native_profiler");
        $__internal_5e11cbd38483b33c2f3ca0b1f45b24d54ec73dd726e2e98f382f40fe26427faf->enter($__internal_5e11cbd38483b33c2f3ca0b1f45b24d54ec73dd726e2e98f382f40fe26427faf_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "TwigBundle:Exception:exception_full.html.twig"));

        $this->parent->display($context, array_merge($this->blocks, $blocks));
        
        $__internal_5e11cbd38483b33c2f3ca0b1f45b24d54ec73dd726e2e98f382f40fe26427faf->leave($__internal_5e11cbd38483b33c2f3ca0b1f45b24d54ec73dd726e2e98f382f40fe26427faf_prof);

    }

    // line 3
    public function block_head($context, array $blocks = array())
    {
        $__internal_42d9b3202a5f01a75e6878239a74088b63e417c1e44bc77bba181da8356c6e93 = $this->env->getExtension("native_profiler");
        $__internal_42d9b3202a5f01a75e6878239a74088b63e417c1e44bc77bba181da8356c6e93->enter($__internal_42d9b3202a5f01a75e6878239a74088b63e417c1e44bc77bba181da8356c6e93_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "head"));

        // line 4
        echo "    <link href=\"";
        echo twig_escape_filter($this->env, $this->env->getExtension('request')->generateAbsoluteUrl($this->env->getExtension('asset')->getAssetUrl("bundles/framework/css/exception.css")), "html", null, true);
        echo "\" rel=\"stylesheet\" type=\"text/css\" media=\"all\" />
";
        
        $__internal_42d9b3202a5f01a75e6878239a74088b63e417c1e44bc77bba181da8356c6e93->leave($__internal_42d9b3202a5f01a75e6878239a74088b63e417c1e44bc77bba181da8356c6e93_prof);

    }

    // line 7
    public function block_title($context, array $blocks = array())
    {
        $__internal_c661b206466ed91bbf8582c9f8f1e58344c5541bb447b17e640e391a49c75e4f = $this->env->getExtension("native_profiler");
        $__internal_c661b206466ed91bbf8582c9f8f1e58344c5541bb447b17e640e391a49c75e4f->enter($__internal_c661b206466ed91bbf8582c9f8f1e58344c5541bb447b17e640e391a49c75e4f_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "title"));

        // line 8
        echo "    ";
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["exception"]) ? $context["exception"] : $this->getContext($context, "exception")), "message", array()), "html", null, true);
        echo " (";
        echo twig_escape_filter($this->env, (isset($context["status_code"]) ? $context["status_code"] : $this->getContext($context, "status_code")), "html", null, true);
        echo " ";
        echo twig_escape_filter($this->env, (isset($context["status_text"]) ? $context["status_text"] : $this->getContext($context, "status_text")), "html", null, true);
        echo ")
";
        
        $__internal_c661b206466ed91bbf8582c9f8f1e58344c5541bb447b17e640e391a49c75e4f->leave($__internal_c661b206466ed91bbf8582c9f8f1e58344c5541bb447b17e640e391a49c75e4f_prof);

    }

    // line 11
    public function block_body($context, array $blocks = array())
    {
        $__internal_0356a1289e034c90feaf601859bbcf9d3e543fa7c5a3545a966e44cc0154e29a = $this->env->getExtension("native_profiler");
        $__internal_0356a1289e034c90feaf601859bbcf9d3e543fa7c5a3545a966e44cc0154e29a->enter($__internal_0356a1289e034c90feaf601859bbcf9d3e543fa7c5a3545a966e44cc0154e29a_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "body"));

        // line 12
        echo "    ";
        $this->loadTemplate("TwigBundle:Exception:exception.html.twig", "TwigBundle:Exception:exception_full.html.twig", 12)->display($context);
        
        $__internal_0356a1289e034c90feaf601859bbcf9d3e543fa7c5a3545a966e44cc0154e29a->leave($__internal_0356a1289e034c90feaf601859bbcf9d3e543fa7c5a3545a966e44cc0154e29a_prof);

    }

    public function getTemplateName()
    {
        return "TwigBundle:Exception:exception_full.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  78 => 12,  72 => 11,  58 => 8,  52 => 7,  42 => 4,  36 => 3,  11 => 1,);
    }
}
