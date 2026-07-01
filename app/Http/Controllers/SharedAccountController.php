<?php

namespace App\Http\Controllers;

use App\Models\SharedAccount;
use App\Services\TotpService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use InvalidArgumentException;

class SharedAccountController extends Controller
{
    public function __construct(private readonly TotpService $totp)
    {
    }

    public function index(Request $request): View
    {
        $query = trim((string) $request->query('q', ''));
        $accounts = SharedAccount::query()
            ->when($query !== '', fn ($builder) => $builder
                ->where('website_domain', 'like', "%{$query}%")
                ->orWhere('login', 'like', "%{$query}%"))
            ->orderBy('website_domain')
            ->orderBy('login')
            ->get()
            ->map(fn (SharedAccount $account) => $this->present($account));

        return view('accounts.index', [
            'accounts' => $accounts,
            'query' => $query,
        ]);
    }

    public function create(): View
    {
        $this->authorizeAdmin();

        return view('accounts.form', [
            'account' => new SharedAccount(),
            'mode' => 'create',
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $this->authorizeAdmin();

        $data = $this->validateAccount($request, requireSecrets: true);
        $this->assertValidSecret($data['two_factor_secret']);

        SharedAccount::create($data);

        return redirect()->route('accounts.index')->with('status', 'Đã thêm tài khoản.');
    }

    public function edit(SharedAccount $account): View
    {
        $this->authorizeAdmin();

        return view('accounts.form', [
            'account' => $account,
            'mode' => 'edit',
        ]);
    }

    public function update(Request $request, SharedAccount $account): RedirectResponse
    {
        $this->authorizeAdmin();

        $data = $this->validateAccount($request, requireSecrets: false);

        if (! empty($data['two_factor_secret'])) {
            $this->assertValidSecret($data['two_factor_secret']);
        } else {
            unset($data['two_factor_secret']);
        }

        if ($data['password'] === null) {
            unset($data['password']);
        }

        $account->update($data);

        return redirect()->route('accounts.index')->with('status', 'Đã cập nhật tài khoản.');
    }

    public function destroy(SharedAccount $account): RedirectResponse
    {
        $this->authorizeAdmin();

        $account->delete();

        return redirect()->route('accounts.index')->with('status', 'Đã xóa tài khoản.');
    }

    public function otp(SharedAccount $account): JsonResponse
    {
        return response()->json([
            'otp' => $this->totp->generate($account->two_factor_secret),
            'seconds_remaining' => $this->totp->secondsRemaining(),
        ]);
    }

    public function password(SharedAccount $account): JsonResponse
    {
        return response()
            ->json(['password' => $account->password])
            ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
    }

    private function present(SharedAccount $account): array
    {
        return [
            'id' => $account->id,
            'website_domain' => $account->website_domain,
            'website_url' => $this->websiteUrl($account->website_domain),
            'login' => $account->login,
            'otp' => $this->totp->generate($account->two_factor_secret),
            'seconds_remaining' => $this->totp->secondsRemaining(),
            'password_url' => route('accounts.password', $account),
            'otp_url' => route('accounts.otp', $account),
            'edit_url' => route('accounts.edit', $account),
            'delete_url' => route('accounts.destroy', $account),
        ];
    }

    private function websiteUrl(string $domain): string
    {
        $domain = trim($domain);

        if (str_starts_with($domain, 'http://') || str_starts_with($domain, 'https://')) {
            return $domain;
        }

        return "https://{$domain}";
    }

    /**
     * @return array{website_domain: string, login: string, password: ?string, two_factor_secret?: string}
     */
    private function validateAccount(Request $request, bool $requireSecrets): array
    {
        return $request->validate([
            'website_domain' => ['required', 'string', 'max:255'],
            'login' => ['required', 'string', 'max:255'],
            'password' => [$requireSecrets ? 'required' : 'nullable', 'string', 'max:1000'],
            'two_factor_secret' => [$requireSecrets ? 'required' : 'nullable', 'string', 'max:255'],
        ]);
    }

    private function assertValidSecret(string $secret): void
    {
        try {
            $this->totp->generate($secret);
        } catch (InvalidArgumentException) {
            throw ValidationException::withMessages([
                'two_factor_secret' => '2FA secret không hợp lệ.',
            ]);
        }
    }

    private function authorizeAdmin(): void
    {
        abort_unless(Auth::user()?->is_admin, 403);
    }
}
