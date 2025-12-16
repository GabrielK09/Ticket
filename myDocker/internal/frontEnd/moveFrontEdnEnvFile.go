package frontEnd

import (
	"log"
	"myDocker/pkg"
	"os"
	"path/filepath"
)

func MoveFile() error {
	// Precisa conferir se no caminho final já tem uma .env com o IP

	existsFileButOtherIp, err := ReadFile()

	if err != nil {
		return err
	}

	if !existsFileButOtherIp {
		currentPath, err := os.Getwd()

		if err != nil {
			log.Fatalf("Erro ao pegar o caminho atual %s", err)
			return err

		}

		log.Println("Vai criar um novo .env com o IP atual")
		fileName, err := CreateFile()

		if err != nil {
			log.Fatalf("Erro ao criar o arquivo %s", err)
			return err

		}

		log.Println("O arquivo foi criado, vai validar o caminho: D:\\Gabriel\\MVPs\\1\\frontend")

		existsPath, err := pkg.CheckExistsPath(
			"D:\\Gabriel\\MVPs\\1\\frontend",
			"C:\\Gabriel\\MVPs\\1\\frontend",
			"C:\\Gabriel\\Projetos\\Ticket\\frontend",
		)

		if err != nil {
			return err
		}

		oldPath := filepath.Join(currentPath, fileName)
		newPath := filepath.Join(existsPath, fileName)

		err = os.Rename(oldPath, newPath)

		if err != nil {
			log.Printf("Erro ao mover o arquivo %s\n", err)

		}

		log.Println("Arquivo movido para: ", existsPath)

		log.Printf("Dir: %s", newPath)

		return nil
	} else {
		return nil
	}
}
