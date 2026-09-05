<h1>New portfolio contact message</h1>

<p><strong>Name:</strong> {{ $contactMessage->name }}</p>
<p><strong>Email:</strong> <a href="mailto:{{ $contactMessage->email }}">{{ $contactMessage->email }}</a></p>
<p><strong>Subject:</strong> {{ $contactMessage->subject ?: 'No subject' }}</p>

<h2>Message</h2>
<p>{!! nl2br(e($contactMessage->message)) !!}</p>

<p>You can reply directly to this email to contact {{ $contactMessage->name }}.</p>
