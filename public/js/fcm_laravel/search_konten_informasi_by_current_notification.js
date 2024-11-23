const urlParams = new URLSearchParams(window.location.search);
const fillInput = urlParams.get("fill_input");
const searchValue = urlParams.get("search_value");

if (fillInput && searchValue) {
    // ketika halaman sudah di load elemennya
    document.addEventListener("DOMContentLoaded", () => {
        document.querySelector(`input#${fillInput}`).value = searchValue;

        // jika fillInput tidak paparan,, karena paparan berada di paling atas
        // kode dibawah berfungsi untuk menaikkan konten informasi yang tempatnya ada di bawah paparan
        if (fillInput !== "paparan") {
            const container = document.querySelector(
                ".container-konten-informasi"
            );
            const paparan = document.querySelector(".paparan-card");
            const kontenInformasiElement = document.querySelector(
                `.${fillInput}-card`
            );

            container.insertBefore(kontenInformasiElement, paparan);
        }
    });
}

// data jukrah memiliki key search sedangkan selain jukrah memiliki key nama konten informasi tersebut (meme, infografis, dll)
const searchKey = fillInput === "jukrah" ? "search" : fillInput;
const dataKontenInformasi = {
    [searchKey]: searchValue,
    page: 1,
};
