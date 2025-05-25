import { FILE_TYPE } from '@/types';
import { router } from '@inertiajs/vue3';
import { ref, Ref } from 'vue';

interface useDialogInterface {
    fileFormat: Ref<FILE_TYPE>;
    onSubmitForm: (dialog: HTMLDialogElement | null) => void;
    transformText: Ref<string>;
}

const fileFormat: Ref<FILE_TYPE> = ref<FILE_TYPE>(FILE_TYPE.CSV);
const transformText: Ref<string> = ref<string>('');

export function useDialog(): useDialogInterface {
    const onSubmitForm = (dialog: HTMLDialogElement | null): void => {
        dialog?.close();

        router.post('/generate', {
            fileFormat: fileFormat.value,
            transformText: transformText.value,
        });
    };

    return {
        fileFormat,
        onSubmitForm,
        transformText,
    };
}
