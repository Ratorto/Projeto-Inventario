<?php
class Inventario
{
    private int $id;
    /** @var SlotInventario[] */
    private array $slots;
}
class SlotInventario
{
    private int $id;
    private int $quantidadeItem;
    private ?Item $item;
    private Inventario $inventario;

    public function __construct(int $quantidadeItem, ?Item $item, Inventario $inventario)
    {
        $this->validarConsistenciaQuantidade($quantidadeItem, $item);
        $this->quantidadeItem = $item === null ? 0 : $quantidadeItem;
        $this->item = $item;
        $this->inventario = $inventario;
    }

    public function getQuantidadeItem(): int
    {
        return $this->quantidadeItem;
    }

    public function getNomeItem(): string
    {
        $this->validarItemExiste();
        return $this->item->getNome();
    }

    public function getDescricaoItem(): string
    {
        $this->validarItemExiste();
        return $this->item->getDescricao();
    }

    public function getImagemItem(): string
    {
        $this->validarItemExiste();
        return $this->item->getImagem();
    }

    public function setQuantidade(int $novaQuantidade)
    {
        $this->validarConsistenciaQuantidade($novaQuantidade, $this->item);
        $this->quantidadeItem = $novaQuantidade;
    }

    private function validarItemExiste(): void
    {
        if ($this->item === null) throw new Exception("Esse slot não possui nenhum item");
    }

    private function validarConsistenciaQuantidade(int $quantidadeItem, ?Item $item): void
    {
        if ($item === null && $quantidadeItem !== 0) {
            throw new \DomainException("Slot vazio não pode ter quantidade diferente de 0");
        }

        if ($item !== null && $quantidadeItem <= 0) {
            throw new \DomainException("Slot com item precisa ter quantidade maior que 0");
        }
    }
}
class Item
{
    private int $id;
    private string $nome;
    private string $descricao;
    private Imagem $imagem;

    public function __construct(string $nome, string $descricao, Imagem $imagem)
    {
        $this->mudarNome($nome);
        $this->mudarDescricao($descricao);
        $this->imagem = $imagem;
    }
    public function getImagem(): string
    {
        return $this->imagem->getCodigoImagem();
    }

    public function getNome(): string
    {
        return $this->nome;
    }

    public function getDescricao(): string
    {
        return $this->descricao;
    }

    public function mudarNome($novoNome): void
    {
        $this->verificarNome($novoNome);
        $this->nome = $novoNome;
    }

    public function mudarDescricao($descricao): void
    {
        $this->verificarDescricao($descricao);
        $this->descricao = $descricao;
    }

    private function verificarNome(string $nome): void
    {
        if ($nome == "")
            throw new \DomainException("O nome não pode ser vazio");
    }

    private function verificarDescricao(string $descricao): void
    {
        if ($descricao == "")
            throw new \DomainException("A descrição da imagem não pode ser vazia");
    }
}

class Imagem
{
    private string $codigoImagem;

    public function __construct(string $codigoImagem)
    {
        $this->codigoImagem = $codigoImagem;
    }

    public function getCodigoImagem(): string
    {
        return 'data:image/png;base64,' . base64_encode($this->codigoImagem);
    }
}
?>