<x-admin-layout>
  <!-- Content Header -->
  <section class="content-header">
      <div class="container-fluid">
          <div class="row mb-2">
              <div class="col-sm-6">
                  <h1><i class="fas fa-comments mr-2"></i> Frequently Asked Questions</h1>
              </div>
              <div class="col-sm-6">
                  <ol class="breadcrumb float-sm-right">
                      <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
                      <li class="breadcrumb-item active">FAQ</li>
                  </ol>
              </div>
          </div>
      </div>
  </section>

  <div class="container py-5">
    <div class="accordion" id="faqAccordion">
      @php
        $faqs = [
          [
            'question' => 'What services does ENETECH offer?',
            'answer' => 'ENETECH provides IT infrastructure solutions, cloud services, managed IT services, and technical support tailored to your business needs.',
          ],
          [
            'question' => 'How can I contact customer support?',
            'answer' => 'You can reach our customer support via the Contact Us page, email, or phone. We also offer a live chat feature on our website during business hours.',
          ],
          [
            'question' => 'What is your response time for support requests?',
            'answer' => 'Our team aims to respond to all support requests within 24 hours. For urgent issues, we provide 24/7 support services.',
          ],
          [
            'question' => 'Do you offer custom IT solutions?',
            'answer' => 'Yes, ENETECH specializes in custom IT infrastructure and cloud solutions tailored specifically to your business requirements.',
          ],
          [
            'question' => 'Can I upgrade my current service plan?',
            'answer' => 'Absolutely! Contact your account manager or our customer service team to discuss upgrade options and pricing.',
          ],
        ];
      @endphp

      @foreach ($faqs as $index => $faq)
      <div class="accordion-item">
        <h2 class="accordion-header" id="heading{{ $index }}">
          <button class="accordion-button {{ $index !== 0 ? 'collapsed' : '' }}" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $index }}" aria-expanded="{{ $index === 0 ? 'true' : 'false' }}" aria-controls="collapse{{ $index }}">
            {{ $faq['question'] }}
          </button>
        </h2>
        <div id="collapse{{ $index }}" class="accordion-collapse collapse {{ $index === 0 ? 'show' : '' }}" aria-labelledby="heading{{ $index }}" data-bs-parent="#faqAccordion">
          <div class="accordion-body">
            {!! nl2br(e($faq['answer'])) !!}
          </div>
        </div>
      </div>
      @endforeach
    </div>
  </div>
</x-admin-layout>
