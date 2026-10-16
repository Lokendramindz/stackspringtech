@extends('layouts.app')
@section('title', $seo->meta_title)
@section('desc', $seo->meta_description)
@section('robots', $seo->meta_robots)
@section('og_image', $seo->og_image)
@section('content')
@php
  $toolGroups = [
    ['label' => 'AI assistants & research', 'intro' => 'Tools for conversation, research, writing and knowledge work.', 'tools' => [
      ['ChatGPT', 'OpenAI', 'Draft, analyze, search and work with files, images and data. Can also power custom product features through the OpenAI API.', 'Content workflows, support assistants, data and product features.', 'https://chatgpt.com/'],
      ['Claude', 'Anthropic', 'An AI assistant for working with documents, research, writing and software tasks, with an API for custom applications.', 'Document-heavy workflows, research and AI features in apps.', 'https://claude.ai/'],
      ['Google Gemini', 'Google', 'Google’s AI assistant and model family for multimodal tasks, product workflows and application integrations.', 'Google Workspace use cases and multimodal product experiences.', 'https://gemini.google.com/'],
      ['Microsoft Copilot', 'Microsoft', 'AI assistance across Microsoft work tools, including support for drafting, summarizing and working with business information.', 'Teams already using Microsoft 365 apps and services.', 'https://copilot.microsoft.com/'],
      ['Perplexity', 'Perplexity AI', 'A web-first answer and research tool that returns sourced responses and offers APIs for adding search to products.', 'Research workflows and grounded, web-connected experiences.', 'https://www.perplexity.ai/'],
    ]],
    ['label' => 'AI for software teams', 'intro' => 'Coding assistants and model platforms for building AI into software.', 'tools' => [
      ['GitHub Copilot', 'GitHub', 'Coding assistance in developer tools and GitHub workflows, including code suggestions, chat and agent features.', 'Developer productivity and repository-aware coding workflows.', 'https://github.com/features/copilot'],
      ['Cursor', 'Anysphere', 'An AI code editor that can use codebase context to suggest edits and help developers work through coding tasks.', 'Teams building and maintaining larger codebases.', 'https://www.cursor.com/'],
      ['OpenAI API', 'OpenAI', 'Application APIs for language, image, audio and other model-powered capabilities.', 'Custom assistants, extraction, generation and multimodal features.', 'https://platform.openai.com/'],
      ['Claude API', 'Anthropic', 'Developer access to Claude models for adding language and reasoning features to applications.', 'Long-form text workflows, coding helpers and AI product features.', 'https://docs.anthropic.com/'],
      ['Gemini API', 'Google', 'Developer tools for integrating Gemini models into applications and services.', 'Multimodal applications and products built on Google Cloud.', 'https://ai.google.dev/'],
    ]],
    ['label' => 'Creative AI', 'intro' => 'Image and visual tools to explore concepts and create production assets.', 'tools' => [
      ['Adobe Firefly', 'Adobe', 'Generative tools for creating and editing images and other creative assets, with connections to Adobe’s creative apps.', 'Campaign concepts, product imagery and creative production.', 'https://www.adobe.com/products/firefly.html'],
      ['Midjourney', 'Midjourney', 'An image and video generation platform for exploring visual directions from prompts and references.', 'Early visual concepts, art direction and inspiration.', 'https://www.midjourney.com/'],
    ]],
    ['label' => 'Knowledge & workflow automation', 'intro' => 'Connect information and automate repeatable steps across business tools.', 'tools' => [
      ['Notion AI', 'Notion', 'AI features inside a workspace for finding, drafting and acting on team knowledge and project information.', 'Internal knowledge, documentation and project workflows.', 'https://www.notion.com/product/ai'],
      ['Zapier', 'Zapier', 'Connects business apps and automates trigger-and-action workflows, with AI features for building and running processes.', 'Lead routing, notifications and no-code app integrations.', 'https://zapier.com/ai'],
      ['n8n', 'n8n', 'A workflow automation platform for connecting services and building custom automations, including AI-enabled flows.', 'Flexible workflow orchestration and API-heavy integrations.', 'https://n8n.io/'],
      ['LangChain', 'LangChain', 'Frameworks and tooling for developing, evaluating and monitoring applications powered by language models.', 'Custom AI applications that need retrieval, tools or orchestration.', 'https://www.langchain.com/'],
      ['Pinecone', 'Pinecone', 'A vector database platform commonly used to store and retrieve information for semantic search and retrieval-augmented generation.', 'Search across private documents and knowledge bases.', 'https://www.pinecone.io/'],
    ]],
  ];
  $groupVisuals = [
    'AI assistants & research' => ['https://images.unsplash.com/photo-1518770660439-4636190af475?auto=format&fit=crop&w=900&q=80', 'Circuit board representing AI systems and data'],
    'AI for software teams' => ['https://images.unsplash.com/photo-1515879218367-8466d910aaa4?auto=format&fit=crop&w=900&q=80', 'Developer workspace with code on screen'],
    'Creative AI' => ['https://images.unsplash.com/photo-1513364776144-60967b0f800f?auto=format&fit=crop&w=900&q=80', 'Creative workspace with art and design materials'],
    'Knowledge & workflow automation' => ['https://images.unsplash.com/photo-1551434678-e076c223a692?auto=format&fit=crop&w=900&q=80', 'Team collaborating around digital workflows'],
  ];
@endphp
<section class="ai-hero reveal"><div class="wrap ai-hero-grid"><div><p class="eyebrow"><span class="ai-live-dot"></span> AI / Tools & applications</p><h1>{{ $pageCopy['content.ai.hero_title'] }}</h1><p class="inner-lead">{{ $pageCopy['content.ai.hero_intro'] }}</p><div class="hero-actions"><a class="btn" href="{{ route('contact', ['service' => 'AI solutions and integration']) }}">Discuss an AI idea <span aria-hidden="true">-></span></a><a class="text-link" href="#ai-tools">Explore the tools <span aria-hidden="true">↓</span></a></div></div><div class="ai-hero-visual"><img src="https://images.unsplash.com/photo-1677442136019-21780ecad995?auto=format&fit=crop&w=1100&q=85" alt="Abstract artificial intelligence network visualization" loading="lazy" onerror="this.onerror=null;this.src='{{ asset('images/og.png') }}'"><div><span>From model to product</span><strong>Choose. Connect. Build.</strong></div><i aria-hidden="true"></i></div></div></section>

<section class="ai-usecases reveal"><div class="wrap sec"><div class="section-heading"><div><p class="eyebrow">Where AI can help</p><h2>Start with a useful outcome.</h2></div><p class="sub">An AI feature earns its place when it solves a clear problem, fits your data and can be reviewed by the people who use it.</p></div><div class="ai-usecase-grid"><article><span>01</span><h3>Answer from your knowledge</h3><p>Help people find information across approved documents, FAQs and internal resources.</p></article><article><span>02</span><h3>Reduce repetitive work</h3><p>Classify enquiries, draft responses and route tasks into the systems your team already uses.</p></article><article><span>03</span><h3>Add AI to your product</h3><p>Plan assistant, search, content or data features around your users and product requirements.</p></article></div></div></section>

<section class="ai-tools-section reveal" id="ai-tools"><div class="wrap sec"><div class="section-heading"><div><p class="eyebrow">AI tools directory</p><h2>Explore tools by what they help you do.</h2></div><p class="sub">A practical overview of widely used platforms. Tool capabilities and availability change, so we confirm the right fit during project discovery.</p></div>
  @foreach ($toolGroups as $group)
    <div class="ai-tool-group"><div class="ai-tool-heading"><div><span>{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }} / TOOL CATEGORY</span><h3>{{ $group['label'] }}</h3></div><p>{{ $group['intro'] }}</p><img class="ai-tool-category-image" src="{{ $groupVisuals[$group['label']][0] }}" alt="{{ $groupVisuals[$group['label']][1] }}" loading="lazy" onerror="this.onerror=null;this.src='{{ asset('images/og.png') }}'"></div><div class="ai-tool-grid">
      @foreach ($group['tools'] as [$name, $maker, $description, $fit, $url])
        <article class="ai-tool-card"><div class="ai-tool-card-top"><span class="ai-tool-mark" aria-hidden="true">{{ strtoupper(substr($maker, 0, 1)) }}</span><span>{{ $maker }}</span></div><h4>{{ $name }}</h4><p>{{ $description }}</p><div class="ai-tool-fit"><strong>Useful for</strong><span>{{ $fit }}</span></div><a href="{{ $url }}" target="_blank" rel="noopener noreferrer">Visit official site <span aria-hidden="true">↗</span></a></article>
      @endforeach
    </div></div>
  @endforeach
</div></section>

<section class="ai-approach reveal"><div class="wrap sec"><div class="section-heading"><div><p class="eyebrow">A considered approach</p><h2>Pick the tool after you understand the work.</h2></div><p class="sub">Model choice is only one part of a useful AI solution. Data access, privacy, cost, quality checks and a clear fallback also matter.</p></div><div class="ai-steps"><article><span>01</span><div><h3>Map the task</h3><p>Define the user, information and desired outcome before choosing a model or platform.</p></div></article><article><span>02</span><div><h3>Compare options</h3><p>Consider quality, integration effort, operating cost, privacy controls and vendor requirements.</p></div></article><article><span>03</span><div><h3>Build and evaluate</h3><p>Prototype on representative examples, check the results and keep people in control of important decisions.</p></div></article></div></div></section>

<section class="inner-cta ai-cta reveal"><div class="wrap inner-cta-row"><div><p class="eyebrow">Have an AI use case?</p><h2>{{ $pageCopy['content.ai.cta_heading'] }}</h2></div><a class="btn" href="{{ route('contact', ['service' => 'AI solutions and integration']) }}">Plan an AI project <span aria-hidden="true">-></span></a></div></section>
@endsection
