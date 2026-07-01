const copyText = async (text) => {
    await navigator.clipboard.writeText(text);
};

const setButtonDone = (button) => {
    const original = button.textContent;
    button.textContent = 'Da copy';
    window.setTimeout(() => {
        button.textContent = original;
    }, 1200);
};

const fetchPassword = async (wrapper) => {
    if (wrapper.dataset.password) {
        return wrapper.dataset.password;
    }

    const response = await fetch(wrapper.dataset.passwordUrl, {
        headers: { Accept: 'application/json' },
    });

    if (!response.ok) {
        throw new Error('Cannot fetch password');
    }

    const data = await response.json();
    wrapper.dataset.password = data.password;

    return data.password;
};

document.addEventListener('click', async (event) => {
    const copyButton = event.target.closest('.copy-btn');
    if (copyButton) {
        await copyText(copyButton.dataset.copy);
        setButtonDone(copyButton);
        return;
    }

    const revealButton = event.target.closest('.reveal-btn');
    if (revealButton) {
        const wrapper = revealButton.closest('[data-password-url]');
        const field = wrapper.querySelector('.password-field');
        const isHidden = field.value === field.dataset.hiddenValue;

        if (isHidden) {
            field.value = await fetchPassword(wrapper);
            revealButton.textContent = 'An';
        } else {
            field.value = field.dataset.hiddenValue;
            revealButton.textContent = 'Hien';
        }

        return;
    }

    const copyPasswordButton = event.target.closest('.copy-password-btn');
    if (copyPasswordButton) {
        const wrapper = copyPasswordButton.closest('[data-password-url]');
        await copyText(await fetchPassword(wrapper));
        setButtonDone(copyPasswordButton);
        return;
    }

    const copyOtpButton = event.target.closest('.copy-otp-btn');
    if (copyOtpButton) {
        const wrapper = copyOtpButton.closest('[data-otp-url]');
        await refreshOtp(wrapper);
        await copyText(wrapper.querySelector('.otp-code').textContent.trim());
        setButtonDone(copyOtpButton);
    }
});

const refreshOtp = async (wrapper) => {
    const response = await fetch(wrapper.dataset.otpUrl, {
        headers: { Accept: 'application/json' },
    });

    if (!response.ok) {
        return;
    }

    const data = await response.json();
    wrapper.querySelector('.otp-code').textContent = data.otp;
    wrapper.querySelector('.otp-countdown').textContent = `${data.seconds_remaining}s`;
    wrapper.dataset.secondsRemaining = data.seconds_remaining;
};

const tickOtp = () => {
    document.querySelectorAll('[data-otp-url]').forEach((wrapper) => {
        const countdown = wrapper.querySelector('.otp-countdown');
        const current = Number.parseInt(wrapper.dataset.secondsRemaining || countdown.textContent, 10);
        const next = Number.isFinite(current) ? current - 1 : 0;

        if (next <= 0) {
            refreshOtp(wrapper);
            return;
        }

        wrapper.dataset.secondsRemaining = next;
        countdown.textContent = `${next}s`;
    });
};

window.setInterval(tickOtp, 1000);
