package frontEnd

import (
	"testing"
)

func TestReadFile(t *testing.T) {
	path, err := ReadFile(
		"D:\\Gabriel\\MVPs\\1\\frontend",
		"C:\\Gabriel\\MVPs\\1\\frontend",
		"C:\\Gabriel\\Projetos\\Ticket\\frontend",
	)

	if err != nil {
		t.Error("Erro:", err)
	}

	if !path {
		t.Error("Erro", path)
	}
}
