<x-app-layout>
    <x-slot name="header">
        <x-admin.header
            :title="$conversation->buyer_id === $user->id ? $conversation->agencyPartner->agency_name : $conversation->buyer->name"
            :subtitle="$conversation->propertyProject?->title"
            :index-url="route('chat.index')"
            index-label="Chat"
        />
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm flex flex-col h-[70vh]">
                {{-- Daftar pesan diperbarui otomatis setiap 5 detik tanpa reload halaman --}}
                <div
                    x-data="{
                        refresh() {
                            fetch(@js(route('chat.messages', $conversation)), { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                                .then(response => response.ok ? response.text() : null)
                                .then(html => {
                                    if (html === null || html === this.$el.innerHTML) return;
                                    const atBottom = this.$el.scrollHeight - this.$el.scrollTop - this.$el.clientHeight < 40;
                                    this.$el.innerHTML = html;
                                    if (atBottom) this.$el.scrollTop = this.$el.scrollHeight;
                                });
                        }
                    }"
                    x-init="$el.scrollTop = $el.scrollHeight; setInterval(() => refresh(), 5000)"
                    class="flex-1 overflow-y-auto p-6 space-y-3"
                >
                    @include('chat._messages')
                </div>

                <form method="POST" action="{{ route('chat.send', $conversation) }}" class="border-t border-gray-100 p-4">
                    @csrf
                    <div class="flex items-end gap-3">
                        <textarea
                            name="body"
                            rows="2"
                            maxlength="{{ \App\Models\Message::MAX_LENGTH }}"
                            required
                            placeholder="Tulis pesan..."
                            class="flex-1 text-sm border-gray-200 rounded-lg focus:ring-primary-500 focus:border-primary-500 resize-none"
                        >{{ old('body') }}</textarea>
                        <button type="submit" class="px-5 py-2.5 bg-primary-600 hover:bg-primary-700 text-white text-sm font-semibold rounded-lg transition">Kirim</button>
                    </div>
                    @error('body')
                        <p class="text-xs text-rose-600 mt-1.5">{{ $message }}</p>
                    @enderror
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
