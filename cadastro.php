<?php
require_once 'banco.php'; 
?>
<!DOCTYPE html>
<html lang="pt-BR">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin="" />
    <link
      rel="stylesheet"
      as="style"
      onload="this.rel='stylesheet'"
      href="https://fonts.googleapis.com/css2?display=swap&family=Lexend%3Awght%40400%3B500%3B700%3B900&family=Noto+Sans%3Awght%40400%3B500%3B700%3B900"
    />

    <title>Stitch Design - Cadastro</title>
    <link rel="icon" type="image/x-icon" href="data:image/x-icon;base64," />

    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <style>
        /* Estilos para animação da mensagem */
        .mensagem-animacao {
            opacity: 0;
            transform: translateY(-10px);
            transition: opacity 0.3s ease-out, transform 0.3s ease-out;
        }
        .mensagem-animacao.show {
            opacity: 1;
            transform: translateY(0);
        }
    </style>
  </head>
  <body>
    <div class="relative flex size-full min-h-screen flex-col bg-black dark group/design-root overflow-x-hidden" style='font-family: Lexend, "Noto Sans", sans-serif;'>
      <div class="layout-container flex h-full grow flex-col">
        <?php include 'navstitch.php'; ?> 

        <div class="px-40 flex flex-1 justify-center py-5">
          <div class="layout-content-container flex flex-col w-[512px] max-w-[512px] py-5 max-w-[960px] flex-1">
            <div class="flex flex-wrap justify-between gap-3 p-4"><p class="text-white tracking-light text-[32px] font-bold leading-tight min-w-72">Criar Conta</p></div>

            <?php if ($mostrarMensagem): ?>
                <div id="mensagem" class="mensagem-animacao <?php echo $mostrarMensagem ? 'show' : ''; ?> p-4">
                    <?php echo $mensagem; ?>
                </div>
                <script>
                    // Remove a mensagem após alguns segundos com animação
                    setTimeout(function() {
                        const mensagemDiv = document.getElementById('mensagem');
                        if (mensagemDiv) {
                            mensagemDiv.classList.remove('show');
                            setTimeout(function() {
                                mensagemDiv.remove();
                            }, 300); // Tempo igual à transição de opacidade
                        }
                    }, 5000); // 5 segundos
                </script>
            <?php endif; ?>

            <form method="POST" action="banco.php?acao=inserirUsuario">
                <div class="flex max-w-[480px] flex-wrap items-end gap-4 px-4 py-3">
                  <label class="flex flex-col min-w-40 flex-1">
                    <p class="text-white text-base font-medium leading-normal pb-2">Nome</p>
                    <input
                      name="nome"
                      type="text"
                      placeholder="Digite seu nome"
                      class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-xl text-white focus:outline-0 focus:ring-0 border border-[#663336] bg-[#331a1b] focus:border-[#663336] h-14 placeholder:text-[#c89295] p-[15px] text-base font-normal leading-normal
                      transition-all duration-300 ease-in-out focus:border-[#a05a5d] focus:shadow-lg focus:shadow-[#663336]/30"
                      value="<?php echo htmlspecialchars($_POST['nome'] ?? ''); ?>"
                    />
                  </label>
                </div>
                <div class="flex max-w-[480px] flex-wrap items-end gap-4 px-4 py-3">
                  <label class="flex flex-col min-w-40 flex-1">
                    <p class="text-white text-base font-medium leading-normal pb-2">Email</p>
                    <input
                      name="email"
                      type="email"
                      placeholder="Digite seu email"
                      class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-xl text-white focus:outline-0 focus:ring-0 border border-[#663336] bg-[#331a1b] focus:border-[#663336] h-14 placeholder:text-[#c89295] p-[15px] text-base font-normal leading-normal
                      transition-all duration-300 ease-in-out focus:border-[#a05a5d] focus:shadow-lg focus:shadow-[#663336]/30"
                      value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>"
                    />
                  </label>
                </div>
                <div class="flex max-w-[480px] flex-wrap items-end gap-4 px-4 py-3">
                  <label class="flex flex-col min-w-40 flex-1">
                    <p class="text-white text-base font-medium leading-normal pb-2">Senha</p>
                    <input
                      name="senha"
                      type="password"
                      placeholder="Digite sua senha"
                      class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-xl text-white focus:outline-0 focus:ring-0 border border-[#663336] bg-[#331a1b] focus:border-[#663336] h-14 placeholder:text-[#c89295] p-[15px] text-base font-normal leading-normal
                      transition-all duration-300 ease-in-out focus:border-[#a05a5d] focus:shadow-lg focus:shadow-[#663336]/30"
                    />
                  </label>
                </div>
                <h3 class="text-white text-lg font-bold leading-tight tracking-[-0.015em] px-4 pb-2 pt-4">Foto de Perfil</h3>
                <p class="text-white text-base font-normal leading-normal pb-3 pt-1 px-4">Escolha uma foto de perfil ou faça upload da sua.</p>
                <div class="flex max-w-[480px] flex-wrap items-end gap-4 px-4 py-3">
                    <label class="flex flex-col min-w-40 flex-1">
                        <p class="text-white text-base font-medium leading-normal pb-2">Fazer Upload de Imagem</p>
                        <div class="flex w-full flex-1 items-stretch rounded-xl">
                            <input
                                placeholder="Escolha um arquivo"
                                class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-xl text-white focus:outline-0 focus:ring-0 border border-[#663336] bg-[#331a1b] focus:border-[#663336] h-14 placeholder:text-[#c89295] p-[15px] rounded-r-none border-r-0 pr-2 text-base font-normal leading-normal
                                transition-all duration-300 ease-in-out focus:border-[#a05a5d] focus:shadow-lg focus:shadow-[#663336]/30"
                                type="file"
                                name="foto"
                            />
                            <div
                                class="text-[#c89295] flex border border-[#663336] bg-[#331a1b] items-center justify-center pr-[15px] rounded-r-xl border-l-0
                                transition-all duration-300 ease-in-out hover:text-white"
                                data-icon="Upload"
                                data-size="24px"
                                data-weight="regular"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" fill="currentColor" viewBox="0 0 256 256">
                                    <path
                                        d="M240,136v64a16,16,0,0,1-16,16H32a16,16,0,0,1-16-16V136a16,16,0,0,1,16-16H80a8,8,0,0,1,0,16H32v64H224V136H176a8,8,0,0,1,0-16h48A16,16,0,0,1,240,136ZM85.66,77.66,120,43.31V128a8,8,0,0,0,16,0V43.31l34.34,34.35a8,8,0,0,0,11.32-11.32l-48-48a8,8,0,0,0-11.32,0l-48,48A8,8,0,0,0,85.66,77.66ZM200,168a12,12,0,1,0-12,12A12,12,0,0,0,200,168Z"
                                    ></path>
                                </svg>
                            </div>
                        </div>
                    </label>
                </div>
                <h3 class="text-white text-lg font-bold leading-tight tracking-[-0.015em] px-4 pb-2 pt-4">Ou escolha uma imagem padrão</h3>
                <div class="grid grid-cols-[repeat(auto-fit,minmax(158px,1fr))] gap-3 p-4">
                    <div class="flex flex-col gap-3">
                        <div
                            class="w-full bg-center bg-no-repeat aspect-square bg-cover rounded-xl hover:scale-105 transition-transform duration-200 ease-in-out cursor-pointer"
                            style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuAUy1_m8FjLQK_nxbrEdt5O_Eup3YIpwnBsdHWrCJ2DES_72FuVIbLJLX29Y7cJrIr4wQXw1dXSf3Yzp9GQ_Uky8GPdOdkStticCdRsqnQG-yKxtx1v1J8_VkMRrJ1sc-HVmZ2rmXbSh43be09wmMfSncRJy4SoR86QpA8CQsAl09HiMvLY18bEDQBNB-mZ0NsddQ7E1r0SLoUKeBh54vZ_SBIEduJRa_3ovIAhJpoivn5r7c_0LaFTHXqJfHyk3RqPCF86f1C5Dg8");'
                        ></div>
                    </div>
                    <div class="flex flex-col gap-3">
                        <div
                            class="w-full bg-center bg-no-repeat aspect-square bg-cover rounded-xl hover:scale-105 transition-transform duration-200 ease-in-out cursor-pointer"
                            style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuBloxoaTSxTL3O7Z53NhxdjTd6cc4sY7NE3RJstn4l1qpj6IYpVi6sC-1NLKDJ4svBvnsOt8aOGt1JvhNoktIPZhm3ArPTlAjnYTyxFPnjRYZke1Djpjzyd_QqNdH5XWd5yDp7upW0XWwIBRLuWfxwtHWsbWLOVz0nG-cSoLlIE_APUPPVyumPqCyfwzSXH4G7tn277B5Zay2HZ55mLO1kqsTcRJmYSjq7t1b0DSK5VkpKDaTO1NLT82XkBkOLYAL-v83ipuAj2Di4");'
                        ></div>
                    </div>
                    <div class="flex flex-col gap-3">
                        <div
                            class="w-full bg-center bg-no-repeat aspect-square bg-cover rounded-xl hover:scale-105 transition-transform duration-200 ease-in-out cursor-pointer"
                            style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuD28hOU7mH8Rpy5qb1L8JBrO4QQ-KR1KsCOX_6_-SOCPuol_ugr1_jk4a_SS1VEVlt50uZh4sjEIrOeS_N0sYRn1l5TkOZfp1fAHi1ELg3KFkilyBijMA-jBs1IlQun-SjVTvbxOAVkH-sT99eLCLJNYuw1eZ_G1FomVBhyiPx4EEbsIJXz5nYeGxFbKRP85pG7P1JcVpE-KGMqs0RpsoPwEHg9H7i_y-W8MF1rCqlsrcgMechGWAG-TMecJVW1aJ9A9fUw4vi4Vwk");'
                        ></div>
                    </div>
                    <div class="flex flex-col gap-3">
                        <div
                            class="w-full bg-center bg-no-repeat aspect-square bg-cover rounded-xl hover:scale-105 transition-transform duration-200 ease-in-out cursor-pointer"
                            style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuC10Ozxk5jNX88obqOngAn5njw8HrjtSMa2E-4ckxJPoz_e_WG7-OrmpbXNys7uQud0H56aJ7oNNZ2-gDGbiEjomNYp8Z5T1CYVGYRG-n4igOgvBfrk_1Vc-XwpBGlynVUwzpClWK65I32KjMjKcTQcVe3k245HOCudrJCUoZ1igEqTYj1eH5sMJeGqo-Cm-jyNFQ_Z4BTfZTocHrASPhQBh1ZMyhYX4Y_L3ekWN8g0kVUMFE0BOq6KNEnZeqgDWytNPIUJzwT1qpg");'
                        ></div>
                    </div>
                    <div class="flex flex-col gap-3">
                        <div
                            class="w-full bg-center bg-no-repeat aspect-square bg-cover rounded-xl hover:scale-105 transition-transform duration-200 ease-in-out cursor-pointer"
                            style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuDLvoIYBAbbzaTbSD6L_AuJXxyd-yPbWiWQ4aZQ9fhPp6OwWUT3tDZUcMF-2mZKN72WYrZVhXFiyqG1U1pyRtiplYIiIh3QD3xEhn8wByXs5etrqDxL2s954wyYj9goEs2sPkqHMDiS0r4EyHpUPCek26HEwThLS9VEtNr1cuc1DrKF3bXZGzGzYrQoyjWNdFLEySrsvFLLaR-DASY-059j-TPRZXjoToXix52wD2bWD9hOHjwRMPMJjr-gV85mjOdffYtWvCD7xyI");'
                        ></div>
                    </div>
                    <div class="flex flex-col gap-3">
                        <div
                            class="w-full bg-center bg-no-repeat aspect-square bg-cover rounded-xl hover:scale-105 transition-transform duration-200 ease-in-out cursor-pointer"
                            style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuCOJaG3t-xpGk_AXBRh05iCfyMat1gPzRe0ZE7j6IKygGpTsRLIS4_8gnQe0mFPeIwULhVcfkAcHhz3FdiL49-W-kwF94cO9PPYurIWQaKgHv_xgZSlzmrYc7UOcIynloKrXkKzH7gz_B3FmCPC8SqAakVq1ewpTPao3jIqYcgSKLvsfCWu4KTronFNkwim75FX2rKvigFbCer7NpLczA_RBgUsq3fUtYstb6Z6Si1hAAmRFBWW8HfNWxXk0nJ5V1X4ol4gblb2sc4");'
                        ></div>
                    </div>
                </div>
                <div class="flex px-4 py-3">
                  <button
                  type="submit"
                  class="flex min-w-[84px] max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-full h-10 px-4 flex-1 bg-[#ea2832] text-white text-sm font-bold leading-normal tracking-[0.015em]
                  hover:bg-[#d01c25] active:scale-95 transition-all duration-200 ease-in-out"
                  >
                  <span class="truncate">Registrar</span>
                </button>
                </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>